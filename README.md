# ToDo-Co

Installation
Clonez le repo :

    git clone https://github.com/platreth/ToDo-Co.git
Modifier le .env avec vos informations.

Installez les dependances :

    composer install
Mettre en place la BDD :

    php bin/console doctrine:database:create
    php bin/console d:s:u -f
    
Installez les fixtures : 
    
    php bin/console d:f:l -n
    
 
