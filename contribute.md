# Document de contribution au projet

## Déclarer un bug ou créer une feature :

Vous pouvez rapporter un bug ou créer une feature sur l’application en créant l’issue sur le repository du projet.

Avant de créer votre issue il y a un ensemble de règles à respecter : 
utiliser le titre de l’issue pour décrire clairement le problème
utiliser le label bug ou feature pour votre issue
donner un maximum de détails à propos de votre environnement (OS,  version de PHP, extensions ...)
décrire les étapes pour reproduire le bug

### Pull request :

#### Étape 1 : 

- Avant de commencer à travailler sur un changement, regarder si quelqu’un n’est pas déjà dessus en vérifiant s’il n’existe pas déjà une issue ou pull request.

#### Étape 2 :

- Sur Github il faudra fork le projet TodoList puis le cloner localement sur votre machine :
    - git clone https://github.com/USERNAME/TodoList.git

- Créez votre branche : 
    - git branch nom_branche

#### Étape 3 :

Une fois la branche créée, placez-vous dedans et commencer à développer votre feature ou corriger le bug. 

Durant le développement vous veillerez à respecter les bonnes pratiques de codage des PSR-1 et 12.

Le code que vous produisez devra être obligatoirement testé avec PHPUnit et/ou Behat.

Une fois vos améliorations apportées vous pouvez faire une pull request sur le repository principal du projet. 

Dans votre pull request vous veillerez à rappeler s’il s’agit d’une feature ou d’une correction de bug et vous choisirez le bon label en fonction.

#### Étape 4 :

Les administrateurs du projet regarderont que votre pull request soit conforme aux recommandations de contribution du projet. Si elle est conforme, votre feature ou correction sera intégré à l’application.
