# symfony-course-beginner
A Beginner Symfony Course

---

## ETAPE 1 :
Le cours : Découverte du Framework Symfony, Connexion à la BDD, Configuration et Première Page

Le TP : Créer sa première page et son premier controlleur

- Création d'un controller simple

---

## ETAPE 2 :
### Le cours : 
Création de l'Entity Post et du CRUD associé

### Le TP : 
Faire évoluer l'entity Post et permettre l'utilisation d'un "slug"

- Ajout de l'attribut slug dans l'entity "Post"
- Ajout du getter et du setter pour la gestion du slug
- Intégration du Bundler Symfony String et utilisation du slugger
- Ajout d'une Route pour accéder au post via le "Slug"
- Contrainte sur l'entity Post pour garantir l'unicité du titre et du slug

---

## ETAPE 3 :

Le cours : Ajout des Utilisateur, configuration de Security et des Accès, Enregistrement et Connexion Utilisateur.

Le TP : Organiser son Application et définir les Accès

- Organisation du dossier Templates :
    - layout
        - base.html.twig
        - base_admin.html.twig
        - common_nav.html.twig
        - admin_nav.html.twig
    - admin
    - user
    - anonymous
- Organisation des Controlleurs
    - Admin
    - User
- Création d'une Dashboard Admin
- Création d'une page Mon Compte pour voir son compte Utilisateur
- Permettre à l'utlisateur de changer son Mot de Passe

---




