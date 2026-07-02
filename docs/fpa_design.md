

# Forum Post Assistant (FPA) — Contributor Design & Architecture Guide
## 1. Core Structural Strategy
The FPA is a standalone, single-file application (`fpa-en.php`) designed to execute in highly unpredictable, broken, or compromised server environments. It relies on **zero external local dependencies**.

To maintain readability inside one massive file, the execution path must flow sequentially in distinct vertical blocks:


┌───────────────────────────┐
  1. Metadata & Language Translations (en-GB Baseline)
  2. Isolated Logic & Audit Functions (fpa_ prefixed)
  3. UI Template Component Generators
  4. Sequential Controller / Test Execution Phase
  5. Pure HTML5 / Bootstrap 5 DOM Display Section

└───────────────────────────┘


---

## 2. Choosing Your Logic Structures
Knowing whether to use an inline script, an isolated function, or a baseline array structure prevents code spaghetti. Contributors must follow these exact design rules:

### A. When to use a Function vs. a Plain Script Block
*   **Use an Isolated Function (`fpa_` prefixed)** for any test that loops over multi-instance objects (such as scanning directory files, deep trees, or array matrices). Functions lock operations inside their own memory scopes, protecting the script from accidental variable overwrites.
*   **Use a Plain Inline Script Block** only for linear, single-evaluation checks (like checking if a single configuration value is on or off) inside the *Test Execution Phase*.

### B. When to Predefine an Array with Defaults vs. an Empty Array
*   **Predefine an Array with Baseline Keys** when testing against an absolute, finite matrix of mandatory configurations where the script **must** know if an expected item exists or is missing (e.g., core Joomla folder trees, or compulsory PHP modules like `json` or `pcre`).
*   **Initialize a Clean Empty Array (`[]`)** when you are discovering unknown, external, or runtime system variations where predefining keys is impossible (e.g., compiling list readouts of rogue folders, custom third-party extensions, or symbolic links).

---

## 3. Reporting Paradigms: RBE vs. Total Reporting
Choosing how data is communicated to the user is vital for balancing a clean UI with deep technical logs.


┌───────────────────────────┐

WHICH REPORTING MODE TO USE?

└───────────────────────────┘

├─► **Is it highly likely to generate hundreds of safe results?**
(e.g., Folder Permissions, File Trees)

└─► Use REPORT-BY-EXCEPTION (RBE)


├─► **Is it a critical baseline environment asset mapping?**
(e.g., PHP Extensions, Apache Modules, Max Post Limits)

└─► Use TOTAL SYSTEM REPORTING


### Report-By-Exception (RBE)
*   **Rule:** If a diagnostic loop scans objects that are expected to be healthy in 95% of cases (like checking hundreds of system directories), **do not generate a table row for every safe object**.
*   **UI Pattern:** If everything passes, output **one single consolidated success box**. If failures occur, output a single master warning, grouping the specific culprits into a single hidden table layout or badge count.

### Total System Reporting
*   **Rule:** For foundational host settings, PHP core limits, or active Apache variables, the support forum helpers need to know exactly *what is available*, not just what is broken.
*   **UI Pattern:** Always render a complete structural data table showing the setting name, the current live environment value, and the recommended baseline threshold side-by-side.

---

## 4. Modern PHP 7.4+ Practices & Code Conventions

### Strict Typing Compliance
The script initializes with `declare(strict_types=1);` at the absolute top of the page. This prevents silent variable conversions.
*   **Do not loose-check numbers:** An operational code like `0` can be misconstrued as false.
*   **Enforce type hints:** Every function must declare parameter and return types strictly:
    ```php
    function fpa_format_bytes(int \$bytes): string {
        return round(\$bytes / 1024 / 1024, 2) . ' MB';
    }
    ```

### Defensive Programming Matrix
Because the FPA often runs on potentially compromised or misconfigured servers, core PHP functions can be restricted, disabled, or altered via `php.ini`.
*   **Never trust native functions directly:** Always verify function availability via `function_exists()` or wrap volatile routines inside defensive sanity filters:
    ```php
    // Good Defensive Example
    \$phpUser = function_exists('posix_getuid') ? posix_getuid() : 'Disabled/Unknown';
    ```

### Global Namespace Simulation
To avoid crashing or overlapping with any existing global system data, user variables, or native settings:
*   All global wrapper arrays must use camelCase starting with the tool target (e.g., `$joomlaFolders`, `$phpSettings`).
*   All freestanding functions must use snake_case prefixed by our specific namespace token: `fpa_` (e.g., `fpa_audit_permissions()`).

---

## 5. UI Architecture: Separation of Concerns
To maximize layout uniformity across the tool:
*   **Never write HTML strings inside audit loops:** Diagnostic logic only builds and returns clean datasets.
*   **Component-Driven Tables:** Use unified template output wrappers (like `fpa_render_data_table()`) to convert raw arrays into semantic, responsive Bootstrap 5 structures.
