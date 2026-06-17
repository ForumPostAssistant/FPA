# Security Policy

Thank you for helping keep the Forum Post Assistant (FPA) secure. We take security vulnerabilities seriously and appreciate your efforts to responsibly disclose any issues you find.

## Supported Versions

The FPA tool is designed to run in modern web environments alongside active content management systems. We only support and patch versions of the FPA that run on the following environments:

| PHP Version | Supported | Notes |
| :--- | :--- | :--- |
| PHP 8.3 and above |  Yes | Recommended for all new deployments. |
| PHP 8.0 – 8.2 |  Yes | Fully supported. |
| PHP 7.4 |  Yes | Minimum baseline supported version. |
| PHP 7.3 and below |  No | Legacy versions are insecure and not supported. |

Please ensure your server infrastructure meets the minimum requirement of **PHP 7.4 or higher** before using this tool or reporting issues.

## Reporting a Vulnerability

Because the FPA is a diagnostic utility script deployed locally to troubleshoot environments, we handle security reports directly and transparently through our public tracking system.

If you discover a security vulnerability in the FPA, please follow these steps:

1. **Check Existing Issues:** Search our open and closed issues on GitHub to see if the vulnerability has already been reported or resolved.
2. **Submit a New Issue:** Navigate to the **Issues** tab in our repository and open a new issue.
3. **Use Clear Labels:** Please title your issue clearly (e.g., `[Security] Potential issue in script execution`) to alert the core maintainers immediately.
4. **Provide Context:** Include detailed steps to reproduce the issue, your exact PHP version, your Joomla version, and the expected versus actual behavior.

*Note: Please do not include sensitive host credentials, live site URLs, or private database passwords in public issue reports.*

## Next Steps and Patches

Once an issue is logged:
* The core maintenance team will triage the report to confirm the vulnerability.
* Fixes will be developed and merged directly into our development branch (`v2-dev`).
* A new production-ready release package will be generated once the patch is verified.
