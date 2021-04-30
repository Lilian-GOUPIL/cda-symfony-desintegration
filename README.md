# Désintégration
## Installation

* Clonez le projet sur votre machine.
* Créez un fichier .env.local qui contiendra votre APP_SECRET ainsi que votre DATABASE_URL.
* Créez la base de données avec les commandes :
    * "php bin/console doctrine:database:create".
    * "php bin/console doctrine:migrations:migrate".
    * "php bin/console doctrine:fixtures:load".
## Utilisation

* Lancez votre projet avec la commande "symfony serve".

### ©2021 Lilian GOUPIL