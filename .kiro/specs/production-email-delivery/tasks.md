# Implementation Plan

## Overview

Este plan sigue la metodología de bug condition exploratorio: primero escribimos tests que demuestran el bug (esperamos que fallen), luego implementamos el fix, y finalmente verificamos que los tests pasen y que el comportamiento existente se preserve.

---

## Tasks

- [ ] 1. Write bug condition exploration test
  - **Property 1: Bug Condition** - Production SMTP Email Delivery Failure
  - **IMPORTANT**: Write this property-based test BEFORE implementing the fix
  - **GOAL**: Surface counterexamples that demonstrate the bug exists in production SMTP configuration
  - **Scoped PBT Approach**: Scope the property to concrete failing cases: production SMTP config (mail.classgoapp.com:465 SSL) with verification and booking notification emails
  - Test that emails sent with production SMTP configuration fail to deliver or generate connection errors
  - Implement test command: `php artisan mail:test-smtp {email}` that attempts SMTP connection and email send
  - Test with various email types: verification emails, booking notifications, tutor notifications
  - Run test on UNFIXED code - expect FAILURE (connection errors, authentication failures, or silent delivery failures)
  - **EXPECTED OUTCOME**: Test FAILS with specific SMTP errors (e.g., "Connection timeout", "Authentication failed", "535 Authentication credentials invalid")
  - Document counterexamples found (e.g., "Verification email to test@gmail.com fails with SMTP connection timeout")
  - Analyze SMTP logs, Laravel logs, and queue status to understand root cause
  - Check `.env` production configuration for MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_ENCRYPTION
  - Verify DNS records (SPF, DKIM, DMARC) using MXToolbox or similar
  - Check if queue workers are running with `php artisan queue:monitor`
  - _Requirements: 1.1, 1.2, 1.3, 1.4_

- [ ] 2. Write preservation property tests (BEFORE implementing fix)
  - **Property 2: Preservation** - Local Mailpit and FCM Notifications
  - **IMPORTANT**: Follow observation-first methodology
  - Observe: Local environment with Mailpit (MAIL_HOST=127.0.0.1:1025) successfully captures emails on unfixed code
  - Observe: FCM push notifications to mobile devices work correctly in production on unfixed code
  - Write property-based test: for all email operations in local environment with Mailpit config, emails are captured successfully
  - Write property-based test: for all FCM notification operations, notifications are delivered to devices successfully
  - Verify email templates, business logic triggers, and notification content remain unchanged
  - Run tests on UNFIXED code
  - **EXPECTED OUTCOME**: Tests PASS (confirms baseline behavior to preserve)
  - Document observed behaviors: Mailpit captures all local emails, FCM delivers to devices, email content/templates are correct
  - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6_

- [ ] 3. Fix production SMTP email delivery

  - [ ] 3.1 Create SMTP diagnostic command
    - Create new Artisan command: `app/Console/Commands/TestSmtpConnection.php`
    - Implement command `php artisan mail:test-smtp {email}` that:
      - Validates SMTP configuration from `.env`
      - Attempts real SMTP connection without sending from app context
      - Tests authentication (username/password)
      - Verifies TLS/SSL handshake
      - Sends test email and captures SMTP response codes
      - Logs detailed diagnostics: connection status, auth status, SMTP codes, error messages
    - Add comprehensive error handling for `Swift_TransportException` and `Swift_RfcComplianceException`
    - Register command in `app/Console/Kernel.php`
    - _Bug_Condition: isBugCondition(X) where X.environment = "production" AND X.mailerConfig.host = "mail.classgoapp.com"_
    - _Expected_Behavior: Command reports specific SMTP errors or successful connection with delivery confirmation_
    - _Preservation: Does not affect existing email sending logic or other mailers_
    - _Requirements: 2.1, 2.3, 2.5_

  - [ ] 3.2 Improve SMTP error logging in mail services
    - Update `app/Services/MailService.php`, `app/Services/BookingNotificationService.php`, `app/Services/TutorVerificationNotificationService.php`
    - Wrap `Mail::to()->send()` calls with try-catch for `Swift_TransportException`
    - Log detailed error context: recipient, SMTP error message, SMTP response code, mailer used, timestamp
    - Differentiate between "enqueued" vs "actually sent" in logs
    - Change success log messages to include SMTP response codes (e.g., "250 OK")
    - Add error re-throwing to make failures visible rather than silent
    - Example implementation:
      ```php
      try {
          Mail::to($user->email)->send(new VerificationEmail($user));
          Log::info('✅ Email sent successfully', [
              'recipient' => $user->email,
              'type' => 'verification',
              'smtp_response' => '250 OK',
              'mailer' => config('mail.default')
          ]);
      } catch (\Swift_TransportException $e) {
          Log::error('❌ SMTP error sending email', [
              'recipient' => $user->email,
              'type' => 'verification',
              'error' => $e->getMessage(),
              'smtp_code' => $e->getCode(),
              'mailer' => config('mail.default')
          ]);
          throw $e;
      }
      ```
    - _Bug_Condition: Captures real SMTP errors for production config instead of reporting false success_
    - _Expected_Behavior: Logs reflect true delivery status with SMTP codes_
    - _Preservation: Existing email content, recipients, and business logic unchanged_
    - _Requirements: 2.5, 3.3, 3.4, 3.5_

  - [ ] 3.3 Increase SMTP timeout configuration
    - Update `config/mail.php`
    - Change SMTP timeout from 5 seconds to 30 seconds: `'timeout' => 30`
    - Add comment explaining why: allows slower SMTP connections to complete
    - _Bug_Condition: Prevents timeout errors for production SMTP (mail.classgoapp.com)_
    - _Expected_Behavior: SMTP connections have sufficient time to complete handshake and send_
    - _Preservation: Does not affect Mailpit or other mailers_
    - _Requirements: 2.3_

  - [ ] 3.4 Diagnose and fix production SMTP configuration
    - Run diagnostic command: `php artisan mail:test-smtp admin@classgoapp.com` on production server
    - Based on diagnostic results, apply appropriate fix:
      - **If MAIL_MAILER=log**: Change to `MAIL_MAILER=smtp` in production `.env`
      - **If SMTP credentials invalid**: Update MAIL_USERNAME and MAIL_PASSWORD with correct credentials
      - **If port blocked**: Try alternative ports (587 instead of 465, or 25) and update MAIL_PORT
      - **If DNS authentication missing**: Add SPF record `v=spf1 a mx include:mail.classgoapp.com ~all`, configure DKIM, add DMARC record
      - **If queue workers not running**: Start with `php artisan queue:work --daemon` and configure supervisor/systemd for auto-restart
      - **If using Mailhog in production**: Change MAIL_HOST from 127.0.0.1:1025 to mail.classgoapp.com
    - Update production `.env` with correct SMTP configuration
    - Verify MAIL_FROM_ADDRESS is valid email from domain (e.g., noreply@classgoapp.com)
    - Document configuration changes in commit message
    - _Bug_Condition: Fixes root cause preventing production SMTP email delivery_
    - _Expected_Behavior: Production emails send successfully with valid SMTP config_
    - _Preservation: Local Mailpit config remains unchanged_
    - _Requirements: 2.1, 2.2, 2.3, 2.4_

  - [ ] 3.5 Configure queue workers for production (if QUEUE_CONNECTION=database)
    - Verify queue connection in production `.env`: check QUEUE_CONNECTION value
    - If using database queues, ensure queue workers are running
    - Document supervisor/systemd configuration for `php artisan queue:work --tries=3 --timeout=90`
    - Add monitoring with `php artisan queue:monitor` to alert on failures
    - Verify email jobs are being processed from `jobs` table
    - _Bug_Condition: Ensures queued emails are actually processed in production_
    - _Expected_Behavior: Queue workers process email jobs and send them via SMTP_
    - _Preservation: Does not affect sync queue or other queue types_
    - _Requirements: 2.4_

  - [ ] 3.6 Verify bug condition exploration test now passes
    - **Property 1: Expected Behavior** - Production SMTP Successful Delivery
    - **IMPORTANT**: Re-run the SAME test from task 1 - do NOT write a new test
    - The test from task 1 encodes the expected behavior (successful SMTP delivery)
    - Run `php artisan mail:test-smtp {email}` again after configuration fixes
    - Send test verification email and booking notification email from production
    - **EXPECTED OUTCOME**: Test PASSES with SMTP 250 OK response codes
    - Verify emails arrive in recipient inboxes (or spam folder if DNS not fully configured)
    - Verify Laravel logs show successful delivery with SMTP response codes
    - Confirm no false positive "success" logs when emails don't actually send
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

  - [ ] 3.7 Verify preservation tests still pass
    - **Property 2: Preservation** - Local Mailpit and FCM Unchanged
    - **IMPORTANT**: Re-run the SAME tests from task 2 - do NOT write new tests
    - Verify local environment with Mailpit still captures emails correctly
    - Test: Send verification email in local → Check Mailpit UI shows captured email
    - Test: Send booking notification in local → Check Mailpit shows correct content
    - Verify FCM notifications still deliver to mobile devices in production
    - Test: Create booking → Verify student/tutor receive FCM push notifications
    - Verify email templates, subjects, and content are unchanged
    - Verify business logic triggers (when emails are sent) are unchanged
    - **EXPECTED OUTCOME**: All preservation tests PASS (no regressions)
    - Run all relevant tests: `php artisan test --filter Email` and `php artisan test --filter Notification`
    - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6_

- [ ] 4. Checkpoint - Ensure all tests pass
  - Run full test suite: `php artisan test`
  - Verify no regressions in other parts of the application
  - Test complete user flow: Register → Receive verification email → Verify email works
  - Test booking flow: Create booking → Receive booking notification email → Email arrives
  - Monitor production logs for SMTP errors after deployment
  - Confirm with real users that emails are being received
  - If issues arise, review logs, check SMTP diagnostics, and ask user for feedback
  - Document any remaining issues or edge cases discovered
  - _Requirements: All requirements 1.1-3.6_

---

## Notes

### Bug Condition Summary
- **C(X)**: Email operations in production with SMTP config mail.classgoapp.com:465 SSL
- **Current Issue**: Emails not delivered, logs show false success or silent failures
- **Root Cause Hypotheses**: Wrong MAIL_MAILER (log instead of smtp), invalid credentials, DNS auth missing (SPF/DKIM), queue workers not running, port blocked, or timeout too short

### Expected Behavior Summary
- Production emails send successfully via SMTP to mail.classgoapp.com
- Logs show real SMTP response codes (250 OK or actual error codes)
- Verification emails and booking notifications arrive in recipient inboxes
- Errors are logged descriptively, not silently ignored

### Preservation Summary
- Local Mailpit email capture unchanged
- FCM push notifications to mobile devices unchanged
- Email templates, content, and business logic unchanged
- All non-production email configurations unchanged

### Testing Strategy
1. **Exploration Phase**: Use diagnostic command to identify root cause on unfixed code
2. **Fix Phase**: Apply appropriate configuration/code fix based on diagnosis
3. **Validation Phase**: Re-run same tests to confirm emails now deliver successfully
4. **Preservation Phase**: Verify local Mailpit and FCM still work correctly
