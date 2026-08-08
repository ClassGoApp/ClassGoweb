let subjectTranslationsCache = null;
let subjectGroupTranslationsCache = null;

async function loadSubjectTranslations() {
  if (subjectTranslationsCache) {
    return subjectTranslationsCache;
  }

  try {
    const response = await fetch("/js/subject-translations.json", {
      cache: "no-store",
    });

    if (!response.ok) {
      throw new Error("No se pudo cargar el JSON de materias.");
    }

    subjectTranslationsCache = await response.json();

    return subjectTranslationsCache;
  } catch (error) {
    console.error("Error cargando traducciones de materias:", error);
    return {};
  }
}

async function loadSubjectGroupTranslations() {
  if (subjectGroupTranslationsCache) {
    return subjectGroupTranslationsCache;
  }

  try {
    const response = await fetch("/js/subject-group-translations.json", {
      cache: "no-store",
    });

    if (!response.ok) {
      return {};
    }

    subjectGroupTranslationsCache = await response.json();

    return subjectGroupTranslationsCache;
  } catch (error) {
    console.error("Error cargando traducciones de grupos:", error);
    return {};
  }
}

function normalizeSubjectLanguage(language) {
  language = String(language || "")
    .toLowerCase()
    .trim();

  if (language.startsWith("en")) {
    return "en";
  }

  if (language.startsWith("pt")) {
    return "pt";
  }

  return "es";
}

async function applySubjectTranslations(selectedLanguage = null) {
  let language =
    selectedLanguage ||
    localStorage.getItem("selected_language") ||
    localStorage.getItem("selectedLanguage") ||
    document.documentElement.lang ||
    "es";

  language = normalizeSubjectLanguage(language);

  const translations = await loadSubjectTranslations();

  document.querySelectorAll(".subject-translatable").forEach((element) => {
    const subjectId = element.dataset.subjectId;
    const fallback = element.dataset.subjectFallback || "";
    const subjectTranslation = translations[subjectId];

    element.textContent =
      subjectTranslation?.[language] || subjectTranslation?.es || fallback;
  });
}

async function applySubjectGroupTranslations(selectedLanguage = null) {
  let language =
    selectedLanguage ||
    localStorage.getItem("selected_language") ||
    localStorage.getItem("selectedLanguage") ||
    document.documentElement.lang ||
    "es";

  language = normalizeSubjectLanguage(language);

  const translations = await loadSubjectGroupTranslations();

  document.querySelectorAll(".subject-group-translatable").forEach((element) => {
    const groupId = element.dataset.subjectGroupId;
    const fallback = element.dataset.subjectGroupFallback || "";
    const groupTranslation = translations[groupId];

    element.textContent =
      groupTranslation?.[language] || groupTranslation?.es || fallback;
  });
}

async function applyAllTranslations(selectedLanguage = null) {
  await applySubjectTranslations(selectedLanguage);
  await applySubjectGroupTranslations(selectedLanguage);
}

/*
|--------------------------------------------------------------------------
| Funciones disponibles globalmente
|--------------------------------------------------------------------------
*/

window.applySubjectTranslations = applySubjectTranslations;
window.applySubjectGroupTranslations = applySubjectGroupTranslations;
window.applyAllTranslations = applyAllTranslations;
window.translateSubjects = applySubjectTranslations;

/*
|--------------------------------------------------------------------------
| Carga inicial
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", function () {
  applyAllTranslations();
});

/*
|--------------------------------------------------------------------------
| Navegación de Livewire
|--------------------------------------------------------------------------
*/

document.addEventListener("livewire:navigated", function () {
  applyAllTranslations();
});

/*
|--------------------------------------------------------------------------
| Cambio de idioma
|--------------------------------------------------------------------------
*/

document.addEventListener("languageChanged", function (event) {
  const language =
    event.detail?.language ||
    event.detail?.lang ||
    event.detail ||
    localStorage.getItem("selected_language") ||
    localStorage.getItem("selectedLanguage");

  applyAllTranslations(language);
});

/*
|--------------------------------------------------------------------------
| Actualizaciones del DOM mediante Livewire
|--------------------------------------------------------------------------
*/

document.addEventListener("livewire:init", function () {
  Livewire.hook("morph.updated", function () {
    setTimeout(() => {
      applyAllTranslations();
    }, 50);
  });
});
