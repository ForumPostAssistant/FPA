# Contributing to the Forum Post Assistant (FPA)

Thank you for your interest in contributing to the FPA! Volunteers like you help make this tool a vital diagnostic asset for the global Joomla! community.

To keep development organised and maintainable, please review the following guidelines before you start writing code or translating strings.

---

## 🚀 The Git Workflow

All active development for the new version of FPA happens in the **`v2-dev`** branch.

1. **Fork the Repository:** Create your own copy of this repository on GitHub.
2. **Clone Locally:** Clone your fork to your computer (e.g., your Mac).
3. **Branch from `v2-dev`:** Never commit directly to `v2-dev` or `main`. Create a descriptive feature branch:
   ```bash
   git checkout -b feature/your-feature-name v2-dev
   # or for translations:
   git checkout -b translation/add-italian-lang v2-dev
   ```
4. **Push & PR:** Push your branch to your fork and submit a Pull Request (PR) targeting the **`v2-dev`** branch of this primary repository.

---

## 🌍 For Localisation & Translation Contributors

We highly value contributions that make the FPA accessible to non-English speaking communities. To prevent breaking the core script layout, please follow these rules:

* **Location of Files:** All translation assets are located inside the root `/lang/` directory.
* **Do Not Touch Core Files:** Localisation contributors should only modify files inside the `/lang/` folder. Do not edit files in the core logic directories unless fixing a translation engine bug.
* **Keep Keys Identical:** Ensure that the text keys (e.g., `FPA_PHP_VERSION` or `['php_version']`) match the English source file exactly. Only translate the text values assigned to those keys.
* **Character Encoding:** All language files must be saved with **UTF-8 encoding** without a Byte Order Mark (BOM).
* **Testing:** Ensure your translated strings do not break the formatting of the generated FPA HTML report tables.

---

## 💻 For Regular Core Team Members

If you are modifying the foundational logic, diagnostic checks, or user interface of the FPA:

* **Environment Requirements:** All code written must support **PHP 7.4, PHP 8.x, and all future stable releases**. Do not use language features introduced in PHP 8.0 or newer if they break backward compatibility with PHP 7.4.
* **Clean Code:** Keep code clean, readable, and free of trailing whitespaces. Ensure line endings are normalised to `LF` (handled automatically if you use our `.gitattributes` file).
* **Code Owners Review:** Changes to critical files may trigger automatic review requirements from core maintainers via the `CODEOWNERS` system.

---

## 🐛 Reporting Bugs & Issues

* If you find a bug or a security issue, please use the appropriate issue template under the **Issues** tab.
* Always specify your exact **Joomla! version** and **PHP version** when reporting problems.
* **Never paste live, unredacted database credentials or absolute server paths** into the issue tracker.

Thank you for dedicating your time to the FPA project!
