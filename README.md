# AnyxTech — Client Management

> Application de gestion des clients, paiements et réabonnements pour AnyxTech.

---

## 🏗️ Architecture

Ce projet suit une architecture **Laravel senior** avec séparation des responsabilités :

```
app/
├── Actions/              # Logique métier (Single Action Classes)
│   └── Client/
│       ├── CalculateReabonnementDateAction
│       ├── ProcessClientPaymentAction
│       ├── SendReabonnementNotificationAction
│       └── SyncClientStatusAction
├── Contracts/            # Interfaces (injection de dépendances)
│   └── MessagingServiceInterface
├── Http/
│   ├── Controllers/
│   │   └── Client/       # Controllers spécialisés par domaine
│   │       ├── ClientCrudController
│   │       ├── ClientListController
│   │       ├── ClientPaymentController
│   │       ├── ClientStatusController
│   │       ├── ClientNotificationController
│   │       └── ClientFilteredListsController
│   └── Requests/         # Form Requests (validation)
│       ├── StoreClientRequest
│       └── UpdateClientRequest
├── Models/               # Eloquent Models (relations, scopes, accessors)
├── Policies/             # Authorization policies
├── Providers/            # Service Providers
└── Services/             # Services externes (SMS/WhatsApp)
    ├── InfobipService
    └── TwilioService
```

### 📐 Principes appliqués

| Principe | Implémentation |
|----------|----------------|
| **Single Responsibility** | Un controller = une responsabilité (CRUD, paiement, notification, etc.) |
| **Action Classes** | Logique métier isolée dans `app/Actions/` — testable et réutilisable |
| **Dependency Injection** | Interfaces bindées via Service Provider (`MessagingServiceInterface`) |
| **Form Requests** | Validation externalisée (`StoreClientRequest`, `UpdateClientRequest`) |
| **Policies** | Autorisation fine par modèle (`ClientPolicy`) |
| **Query Scopes** | Requêtes réutilisables directement sur les modèles (`Client::actifs()`, `Client::payesPourMois()`) |
| **Repository-ready** | Les services SMS implémentent une interface commune pour swap facile |

---

## 🚀 Installation

### Prérequis

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM

### 1. Cloner le dépôt

```bash
git clone https://github.com/your-org/anyxtech-client-management.git
cd anyxtech-client-management
```

### 2. Installer les dépendances

```bash
composer install
npm install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurer la base de données

Dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anyxtech_client_management
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Services SMS/WhatsApp (optionnel)

```env
# Infobip
INFOBIP_BASE_URL=https://api.infobip.com
INFOBIP_TOKEN=your_token
INFOBIP_SENDER=AnyxTech

# Twilio (alternative)
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_FROM=+XXXXXXXXX
TWILIO_WHATSAPP_FROM=whatsapp:+XXXXXXXXX
```

### 6. Migrations & Seed

```bash
php artisan migrate
# php artisan db:seed   # optionnel
```

### 7. Lancer l'application

```bash
npm run build       # ou npm run dev pour le hot-reload
php artisan serve
```

👉 [http://localhost:8000](http://localhost:8000)

---

## 📋 Rôles utilisateurs

| Rôle | Permissions |
|------|-------------|
| **Admin** | CRUD complet, paiements, notifications, exports, suspension |
| **Commercial** | Lecture, création de clients, listes filtrées |

---

## 🧪 Tests

```bash
php artisan test
```

---

## 📦 Scripts utiles

```bash
composer run dev     # Lance server, queue, logs et Vite en parallèle
composer run test    # Lance les tests
npm run build        # Build assets production
```

---

## 📄 Licence

MIT — AnyxTech © 2026
