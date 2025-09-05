---
applyTo: '**'
---

# Specs:

- WordPress 6.8.2
- PHP 8.2.27
- MySQL 8.0

## Coding Standards
- Follow the WordPress coding standards: https://developer.wordpress.org/coding-standards/
- Use context7 tool to check latest coding standard
- Use PHP 8.2 features and syntax where applicable.
- Use strict typing and return types in PHP 8.2.
- Follow best practices for security and performance.
- Test every newly added function using PHPCS and fix using PHP CodeSniffer (PHPCBF).

## Testing
- Write unit tests for all new features and bug fixes.
- Use PHPUnit for testing.

## Process
- Always split tasks into small manageable pieces.
- Whenever you done with one task, check the task 
- Then stage all changes
- Commit the changes with clear and concise commit messages. Follow the Conventional Commits specification: https://www.conventionalcommits.org/en/v1.0.0/
- Then stop, and ask me if I want to review current implementation or execute next task.
- If the implementation is approved, then push the changes to remote repository.
- If the implementation is not approved, then fix the issues and repeat the process.
- If a feature requires Setting UI, build the UI using WordPress Settings API and follow WordPress admin design guidelines. Then build the backend functionality.
