# Projet Alert MNS

Ce projet est réalisé dans le cadre de la formation MNS développeur web et web mobile.

A chaque commit:

- git commit -a -m "prefix: commit conventionnel"
- git cliff --bump -o CHANGELOG.md
- git commit -a -m "version X.X.X"

si patch, git tag avant

Pour fonctionner ce projet doit avoir un serveur apache avec les mdoules suivant actif:

- Headers_module
- Rewrite_module

Il nécessite aussi les programmes tiers suivant:

- Composer
- OpenSSL
- Perl

TODO voir pourquoi pas possible de définir une clé en auto incrément sur certaines tables de la bdd

le refresh token généré contient les informations de la requête de connexion,
puis lorsque l'utilisateur demande un nouveau access avec le refresh, on compare le contenu décrypté du token avec le contenu de la requête de récupération
