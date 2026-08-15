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

/**
 * Obtiene la traducción de una materia por su ID
 * @param {number|string} subjectId - ID de la materia
 * @param {string|null} selectedLanguage - Idioma específico (opcional, usa el actual si es null)
 * @returns {string|null} - Traducción o null si no hay cache todavía
 */
window.getSubjectTranslation = function(subjectId, selectedLanguage = null) {
  // Si no hay cache todavía, devolver null
  if (!subjectTranslationsCache) {
    return null;
  }

  let language =
    selectedLanguage ||
    localStorage.getItem("selected_language") ||
    localStorage.getItem("selectedLanguage") ||
    document.documentElement.lang ||
    "es";

  language = normalizeSubjectLanguage(language);

  const translation = subjectTranslationsCache[subjectId];

  // Devolver traducción del idioma solicitado, fallback ES, o null
  return translation?.[language] || translation?.es || null;
};

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

/**
 * Traduce las opciones de Select2 leyendo desde el DOM
 */
async function translateSelect2OptionsFromDOM(options, selectedLanguage) {
  let language =
    selectedLanguage ||
    localStorage.getItem("selected_language") ||
    localStorage.getItem("selectedLanguage") ||
    "es";

  language = normalizeSubjectLanguage(language);

  const translations = await loadSubjectTranslations();
  const translatedData = [];

  options.each(function () {
    const $option = window.jQuery(this);
    const subjectId = $option.val();
    const originalText = $option.text();

    if (!subjectId) {
      translatedData.push({
        id: "",
        text: originalText,
      });
      return;
    }

    const subjectTranslation = translations[subjectId];
    const translatedText =
      subjectTranslation?.[language] ||
      subjectTranslation?.es ||
      originalText;

    translatedData.push({
      id: subjectId,
      text: translatedText,
    });
  });

  return translatedData;
}

/**
 * Aplica traducciones al Select2 #subjects
 */
async function applySubjectsSelect2Translations(selectedLanguage = null) {
  if (
    typeof window.jQuery !== 'function' ||
    typeof window.jQuery.fn?.select2 !== 'function'
  ) {
    return;
  }

  const $subjectsSelect = window.jQuery("#subjects");

  if (!$subjectsSelect.length || !$subjectsSelect.hasClass("select2-hidden-accessible")) {
    return;
  }

  const currentValue = $subjectsSelect.val();
  const options = $subjectsSelect.find("option");
  const translatedData = await translateSelect2OptionsFromDOM(options, selectedLanguage);

  const dropdownParent = $subjectsSelect.data("parent")
    ? window.jQuery($subjectsSelect.data("parent"))
    : undefined;

  $subjectsSelect.select2("destroy");
  $subjectsSelect.empty();
  $subjectsSelect.select2({
    placeholder: translatedData.find(item => item.id === "")?.text || "Select a subject",
    data: translatedData,
    allowClear: true,
    width: "100%",
    dropdownParent: dropdownParent,
  });

  if (currentValue) {
    $subjectsSelect.val(currentValue).trigger("change.select2");
  }
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
window.applySubjectsSelect2Translations = applySubjectsSelect2Translations;

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
  applySubjectsSelect2Translations(language);
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
