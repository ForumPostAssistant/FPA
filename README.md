# Forum Post Assistant (FPA) — Version 2 (Development)

The Forum Post Assistant (FPA) is a diagnostic script designed to gather_FPA_ information about a local server environment and a Joomla! installation. It formats this data into a standardized BBCode or Markdown block, allowing users to easily copy and paste the metrics into the Joomla! community forums for troubleshooting support.

This repository contains the active development branch (`v2-dev`) for the completely redesigned next generation of the FPA utility.

---

## System Requirements

To run this version of the FPA, your hosting or local development environment must meet the following baseline requirements:

* PHP Version: PHP 7.4, PHP 8.x, or newer stable releases.
* CMS Support: Modern installations of Joomla! matching these PHP targets. (Generally, Joomla 3.9.13 and above)
* Server Requirements: PHP cURL support enabled to fetch remote localization packages.

Note: Legacy environments running PHP 7.3 or older are insecure and are not supported by this version of the script.

---

## How to Use (Development Testing)

1. Download or clone the `v2-dev` branch of this repository.
2. Upload only the core utility script `fpa-en.php` into the root folder of your Joomla! installation.
3. Access the script via your web browser by navigating to:
   ```text
   https://yourdomain.com/fpa-en.php
   ```

When loaded, the FPA script automatically detects your browser language, fetches the corresponding translation package directly from the official GitHub repository via cURL, caches it locally, and dynamically overwrites the default language array.

Warning: Always delete `fpa-en.php` and from your server immediately after you finish posting your forum request. Leaving diagnostic scripts on a public server poses a security risk.

---

## Language Localisation & Translation

Version 2 introduces a dynamic translation delivery framework.
* All source localization definitions, keys, and translation files are stored entirely within the root `/lang/` directory of this GitHub repository.
* The script pulls these assets directly on demand based on the end-user's browser settings.
* If you would like to help translate the FPA into your native language, please check our contribution guidelines.

---

## Contributing

We welcome contributions from both code developers and language translators! Please read our CONTRIBUTING.md file for details on our workflow, branching models, and code standards.

For security vulnerabilities, please consult our public SECURITY.md guidelines before opening an issue.
