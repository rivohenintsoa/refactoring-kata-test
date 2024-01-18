# Refactoring Kata Test

## Overview

This Laravel application is undergoing a series of refactoring stages to enhance its structure and maintainability. The key stages include:

1. **Models without Database:**

    - Entities are now implemented using Laravel Models without a database connection.

2. **Laravel Services and Actions:**

    - Extensive use of Laravel Services and Actions to streamline functionalities.

3. **Custom Command for Message Generation:**

    - A custom command is available to generate messages.

4. **Code Reorganization:**

    - The codebase has been refactored for improved readability and maintainability.

## Installation

Please follow the steps below to install the project:

1. First, install Docker and Docker Compose from the official website: [Docker Installation](https://docs.docker.com/get-docker/).

2. Clone the repository using the following command:
    ```bash
    git clone https://github.com/your-username/your-repo.git
    ```
3. Execute the following commands to build and start the Docker containers
    ```bash
    docker compose build
    ```
    ```bash
    docker compose up -d
    ```
4. Log in to the container using the following command:
    ```bash
    docker compose exec php bash
    ```
5. Execute the following command to install dependencies:
    ```bash
    composer install
    ```
6. Test app by running:
    ```bash
    php artisan message
    ```
