# Projet Alert MNS

Ce projet est réalisé dans le cadre de la formation MNS développeur web et web mobile.

A chaque commit:

- git commit -a -m "prefix: commit conventionnel"
- git cliff --bump -o CHANGELOG.md
- git commit -a -m "version X.X.X"

si patch, git tag avant

Pour fonctionner ce projet doit avoir un serveur apache avec les modules suivant actif:

- Headers_module
- Rewrite_module

et la directive suivante activé dans le httpd.conf :

- HostnameLookups On

Il nécessite aussi les programmes tiers suivant:

- Composer
- OpenSSL
- Perl
