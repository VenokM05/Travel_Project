# Getting Started

<cite>
**Referenced Files in This Document**
- [composer.json](file://composer.json)
- [package.json](file://package.json)
- [config/app.php](file://config/app.php)
- [config/database.php](file://config/database.php)
- [config/cache.php](file://config/cache.php)
- [vite.config.js](file://vite.config.js)
- [resources/js/app.js](file://resources/js/app.js)
- [bootstrap/app.php](file://bootstrap/app.php)
- [routes/web.php](file://routes/web.php)
- [database/migrations/0001_01_01_000000_create_users_table.php](file://database/migrations/0001_01_01_000000_create_users_table.php)
- [database/seeders/DatabaseSeeder.php](file://database/seeders/DatabaseSeeder.php)
- [database/factories/UserFactory.php](file://database/factories/UserFactory.php)
</cite>

## Table of Contents
1. [Introduction](#introduction)
2. [Prerequisites](#prerequisites)
3. [Installation Steps](#installation-steps)
4. [First Run Setup](#first-run-setup)
5. [Development Workflow](#development-workflow)
6. [Common Setup Issues](#common-setup-issues)
7. [Project Navigation](#project-navigation)
8. [Troubleshooting Guide](#troubleshooting-guide)
9. [Conclusion](#conclusion)

## Introduction
Welcome to the Travel Project, a Laravel-powered travel social network application. This guide will help you set up the development environment, configure the application, and get your first-run experience working smoothly. Whether you're new to Laravel or an experienced developer, this document provides a streamlined path to get the project running locally.

## Prerequisites
Before installing the project, ensure your system meets the following requirements:

- PHP: Version 8.2 or higher
- Composer: Latest stable version
- Node.js: LTS recommended (for asset compilation and development server)
- Database: SQLite (default), MySQL/MariaDB, PostgreSQL, SQL Server, or Redis (optional)
- Web Server: Apache or Nginx (or use Laravel's built-in development server)

These requirements are enforced by the project configuration and scripts.

**Section sources**
- [composer.json:8-12](file://composer.json#L8-L12)
- [config/database.php:20](file://config/database.php#L20)
- [config/cache.php:18](file://config/cache.php#L18)

## Installation Steps
Follow these steps to install and configure the project dependencies:

1. **Install PHP Dependencies**
   - Open a terminal in the project root.
   - Run the Composer installer to fetch PHP packages defined in the manifest.
   - This installs Laravel framework, Tinker, and development tools.

2. **Create Environment Configuration**
   - The Composer scripts automatically copy `.env.example` to `.env` if it does not exist.
   - Review and customize the `.env` file for your environment (database credentials, app URL, etc.).

3. **Generate Application Key**
   - Laravel requires a valid application key for encryption and session handling.
   - The Composer setup script generates a secure key during the initial setup.

4. **Install Node.js Dependencies**
   - Install frontend dependencies using npm as defined in the package manifest.
   - This includes Vite, Tailwind CSS, and related build tools.

5. **Compile Assets**
   - Build the frontend assets using the configured Vite pipeline.
   - This compiles CSS and JavaScript for development and production.

6. **Run Database Migrations**
   - Apply all pending migrations to set up the database schema.
   - The default connection is SQLite, but you can switch to MySQL/MariaDB, PostgreSQL, or SQL Server by updating the environment configuration.

7. **Seed Initial Data (Optional)**
   - Optionally seed the database with initial records using the provided seeder.
   - The default seeder creates a sample user account for testing.

8. **Start the Development Server**
   - Launch the Laravel development server and watch frontend assets with a single command.
   - This starts the backend server, queue listener, log tailing, and Vite dev server concurrently.

**Section sources**
- [composer.json:35-69](file://composer.json#L35-L69)
- [package.json:5-21](file://package.json#L5-L21)
- [vite.config.js:1-12](file://vite.config.js#L1-L12)
- [resources/js/app.js:1-8](file://resources/js/app.js#L1-L8)

## First Run Setup
Complete these essential steps after installation to prepare the application for development:

1. **Environment Configuration**
   - Set the application name, environment, and debug level in the `.env` file.
   - Configure the database connection (SQLite by default) and adjust credentials as needed.
   - Set the application URL and timezone according to your deployment environment.

2. **Database Setup**
   - For SQLite, ensure the database file exists and is writable by the web server.
   - For MySQL/MariaDB/PostgreSQL/SQL Server, create the database and user with appropriate permissions.
   - Configure SSL settings if connecting to external databases.

3. **Run Migrations**
   - Execute the migration command to create tables defined in the migration files.
   - The project includes comprehensive migrations for users, posts, budgets, itineraries, and more.

4. **Seed Initial Data**
   - Run the database seeder to populate initial records.
   - The default seeder creates a test user account for quick sign-in.

5. **Compile Assets**
   - Build frontend assets using Vite to generate optimized CSS and JavaScript bundles.

6. **Start Development Server**
   - Use the development script to launch the application with hot reloading and concurrent services.

**Section sources**
- [config/app.php:16-100](file://config/app.php#L16-L100)
- [config/database.php:33-117](file://config/database.php#L33-L117)
- [database/migrations/0001_01_01_000000_create_users_table.php:12-55](file://database/migrations/0001_01_01_000000_create_users_table.php#L12-L55)
- [database/seeders/DatabaseSeeder.php:16-24](file://database/seeders/DatabaseSeeder.php#L16-L24)
- [composer.json:35-69](file://composer.json#L35-L69)

## Development Workflow
The project includes pre-configured scripts to streamline local development:

- **Setup Script**: One-command setup that installs dependencies, generates keys, runs migrations, installs npm packages, and builds assets.
- **Development Script**: Concurrently runs the Laravel development server, queue listener, log tailing, and Vite dev server for a seamless DX.
- **Testing Script**: Clears configuration cache and executes the test suite.

Recommended development flow:
1. Start the development environment using the provided script.
2. Access the application at the configured URL.
3. Use the queue listener for background jobs and the log tailer for real-time insights.
4. Modify frontend assets; Vite handles hot reloading automatically.

**Section sources**
- [composer.json:35-69](file://composer.json#L35-L69)
- [vite.config.js:1-12](file://vite.config.js#L1-L12)

## Common Setup Issues
Below are frequently encountered setup problems and their solutions:

- **PHP Version Compatibility**
  - Ensure PHP 8.2+ is installed. Lower versions will fail to load required extensions or syntax.
  - Verify your runtime matches the Composer requirement.

- **Missing Database Extension**
  - For MySQL/MariaDB, ensure the PDO MySQL extension is enabled.
  - For PostgreSQL, enable the PDO PgSQL extension.
  - For SQLite, ensure the PDO SQLite extension is available.

- **Permission Denied on SQLite Database**
  - Ensure the `database/database.sqlite` file exists and is writable by the web server process.
  - On shared hosting, verify file ownership and permissions.

- **Composer Autoloader Issues**
  - Clear Composer cache and regenerate autoload files if classes are not found.
  - Re-run the Composer install command after making changes to the manifest.

- **Node/npm Version Mismatch**
  - Use the latest LTS Node.js version compatible with the project's Vite configuration.
  - Clear the npm cache if dependency resolution fails.

- **Asset Compilation Failures**
  - Ensure all npm dependencies are installed before building assets.
  - Check for missing build tools or outdated Node versions.

- **Environment Configuration Errors**
  - Verify the `.env` file exists and contains valid database credentials.
  - Confirm APP_KEY is present and not empty.

- **Migration/Seeding Failures**
  - Check database connectivity and credentials.
  - Ensure the target database exists and is accessible.
  - For SQLite, verify the database file path is correct and writable.

**Section sources**
- [composer.json:8-12](file://composer.json#L8-L12)
- [config/database.php:33-117](file://config/database.php#L33-L117)
- [config/cache.php:18](file://config/cache.php#L18)

## Project Navigation
Once the application is running, explore the following key areas:

- **Application Bootstrap**: The application bootstrapping configuration defines routing, middleware, and exception handling.
- **Web Routes**: The main route file defines the application's public endpoints, including authentication, dashboards, and resource controllers.
- **Controllers**: The controller namespace includes dedicated controllers for authentication, profiles, itineraries, budgets, social features, and more.
- **Models**: Eloquent models represent the application's data structures, including users, posts, budgets, itineraries, and relationships.
- **Views**: Blade templates provide the frontend UI for authentication, dashboards, social feeds, and administrative interfaces.
- **Database**: Migrations define the schema for users, posts, budgets, itineraries, and supporting tables.
- **Seeders**: Database seeders populate initial data for testing and development.

Key navigation points:
- Home Page: Root route serves the welcome view.
- Dashboard: Authenticated users access the dashboard after login.
- Authentication: Built-in authentication routes handle registration, login, password reset, and email verification.
- Social Features: Routes for user discovery, following, posts, likes, comments, stories, and reels.
- Administrative: Resource routes for itineraries, budgets, todos, and memories.

**Section sources**
- [bootstrap/app.php:7-18](file://bootstrap/app.php#L7-L18)
- [routes/web.php:6-89](file://routes/web.php#L6-L89)

## Troubleshooting Guide
Use these diagnostic steps to resolve common issues:

- **Application Fails to Start**
  - Check PHP error logs and Laravel logs in the storage directory.
  - Verify the application key is present and valid.
  - Confirm database connectivity and credentials.

- **Migrations Fail**
  - Ensure the database exists and is accessible.
  - Check migration file permissions and syntax.
  - Run the migration command with verbose output to identify errors.

- **Assets Not Loading**
  - Verify Node.js and npm are installed and up-to-date.
  - Reinstall npm dependencies and rebuild assets.
  - Check Vite configuration and port availability.

- **Authentication Issues**
  - Confirm session configuration and database sessions table exist.
  - Verify email verification and password reset routes are functioning.
  - Check middleware configuration for protected routes.

- **Queue and Background Jobs**
  - Ensure the queue listener is running and connected to the correct queue.
  - Verify database or Redis configuration for job storage.
  - Monitor job failures and retry policies.

- **Cache and Session Problems**
  - Clear application cache and configuration cache.
  - Verify cache store configuration and connectivity.
  - Check session database table and lock configurations.

**Section sources**
- [config/app.php:16-100](file://config/app.php#L16-L100)
- [config/database.php:130-133](file://config/database.php#L130-L133)
- [config/cache.php:35-102](file://config/cache.php#L35-L102)

## Conclusion
You now have the essential steps to install, configure, and run the Travel Project locally. Use the provided scripts to automate setup, leverage the development server for rapid iteration, and refer to the troubleshooting guide for common issues. As you become familiar with the project, explore the controllers, models, and views to understand the application's architecture and extend functionality as needed.