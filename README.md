# 🏥 Cabinet Médical
Application web de gestion des rendez-vous médicaux développée 
## Pour cloner le projet chez vous 
### 1. Cloner le dépôt
```bash
git clone <URL_DU_REPO>
cd CabinetMedical
```
### 2. Installer les dépendances PHP et JS

```bash
composer install
npm install
```
### 3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```
Modifier le fichier `.env` avec vos informations :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_db
DB_USERNAME=votre_nom_utilisateur
DB_PASSWORD=votre_mot_de_passe
```
Pour l'envoi d'e-mails (confirmation de rendez-vous) :
```env
MAIL_MAILER=smtp
MAIL_HOST=votre_host
MAIL_PORT=587
MAIL_USERNAME=votre_email
MAIL_PASSWORD=votre_mot_de_passe
MAIL_FROM_ADDRESS=no-reply@cabinet-medical.com
```
```bash
php artisan migrate --seed
```

```bash
npm run build
```

```bash
php artisan serve
```
Ouvrez ensuite `http://127.0.0.1:8000` 

## API

Ces endpoints sont accessibles :
GET /api/appointments : Liste de tous les rendez-vous
POST /api/appointments : Créer un rendez-vous
GET /api/appointments/search : Rechercher des rendez-vous
GET /api/appointments/{id} : Détail d'un rendez-vous
GET /api/doctors : Liste des médecins

## Comptes de connexion 
- *Patient* — 
email : admin@cabinet-medical.fr  
mdps :password
- *Médecin et admin* — :
email : yasmine14@gmail.com
mdps: Yasmine12

######
- POST /api/login — connexion
- POST /api/register — inscription (patient)
- GET /api/external/appointments — liste des rendez-vous 
- POST /api/external/appointments — création d’un rendez-vous 
- GET /api/user — utilisateur connecté
- POST /api/logout — déconnexion
-GET /api/appointmentsListe tous les rendez-vous
-POST api/appointments -Créer un rendez-vous
-GET /api/appointments/search - Recherche en temps réel
-GET /api/appointments/{id}Voir un rendez-vous
-GET api/doctors -Liste tous les médecins

