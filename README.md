## Point of Sale

___

### Table of Contents

1. [Folder Structure](#folder-structure)
2. [Installation](#installation)
    1. [Clone](#clone)
    2. [Install Admin Panel](#install-admin-panel)
    3. [Install Client Application](#install-client-app)
3. [Run Application](#run-application)
    1. [Admin Panel](#run-admin-panel)
    1. [Client Application](#run-client-app)

___

### <a href="#folder-structure">Folder Structure</a>

   ```
   ── point-of-sale         # Root directory.
      ├── docs              # All useed themes and resources.
      ├── PointOfSale       # Admin Panel and Customer Side API application.  
      ├── pointofsaleview   # Customer View - Vue Application
      └── README.md         # Documentation for the project.    
   ```

___

### <a href="#installation">Installation</a>

#### <a href="#clone-repository">Clone Repository</a>

```bash
#Via HTTP:     
https://github.com/devskill-dev/point-of-sale.git  
#or, Via SSH:  
git@github.com:devskill-dev/point-of-sale.git
```

___

#### <a href="#install-admin-panel">Install Admin Panel</a>

Two Templates are used for **_<u>PointOfSale</u>_**. One for landing page, another foe main admin panel.  
For admin panel we used **AdminLTE**  
And, for landing page **Arsha** is used.

1. Navigate to `PointOfSale` folder
   ```bash
   cd PointOfSale
   ```
2. Install dependencies
   ```bash
   # 1. update and/or install php packages based on your system
   composer update
   # or just try to install
   composer install
   
   # 2. install node packages
   npm install
   ```
3. Create & Update `.env` file
    1. ``` copy .env.example .env ```
    2. Update application name
    3. Generate app key `php artisan key:generate`
    3. Create database for this application and update database connection section
    4. Update mail sending credentials.


4. Create Tables and Seed with data
   ```bash
   php artisan migrate --seed
   ```
5. Generate & Publish JWT Secret Key
   ```bash
   php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
   php artisan jwt:secret
   ```

___

#### <a href="#install-client-app">Install Client App</a>

Client Application is based on _Vue.js_. We used **CoreUI** template as the base. The version used for the app is stored
in docs.  
It is stored in **_<u>pointofsaleview</u>_** folder.

**<u>Installation Steps</u>**

1. Navigate to `pointofsaleview` folder
   ```bash
   cd pointofsaleview
   ```
2. Install dependency via **yarn**
   ```bash
   yarn install
   ```

___

### <a href="#run-application">Run Application</a>

#### <a href="#run-admin-panel">Run Admin Panel</a>

   ```bash
   php artisan serve
   ```

___

#### <a href="#run-client-app">Run Client App</a>

   ```bash
   npm run serve
   ```
