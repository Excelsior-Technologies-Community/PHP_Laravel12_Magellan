# PHP_Laravel12_Magellan

## Introduction

PHP_Laravel12_Magellan is a Laravel 12 demonstration project that shows how to work with geospatial data using the Laravel Magellan package and PostGIS in PostgreSQL.

Geospatial data allows applications to store and process geographic coordinates such as latitude and longitude. With the help of PostGIS and Laravel Magellan, developers can perform advanced spatial operations such as measuring distances, locating nearby places, and analyzing geographic relationships directly within the database.

This project demonstrates how Laravel applications can integrate with PostGIS to store and query spatial data efficiently using Eloquent models and spatial database functions.

---

## Project Overview

The goal of this project is to demonstrate a simple Ports Management System that stores ports with their geographic coordinates and performs spatial queries using Laravel Magellan.

The project covers the following key concepts:

- Configuring PostgreSQL with the PostGIS extension

- Installing and configuring the Laravel Magellan package

- Creating spatial geometry columns in Laravel migrations

- Storing geographic coordinates (latitude and longitude) as spatial data

- Using Laravel Eloquent models with spatial casting

- Performing distance-based spatial queries

- Retrieving ports ordered by their distance from a specific location

Using this setup, the application can calculate distances between locations and identify ports that are geographically closest to a given point.

---

## What is Laravel Magellan?

Laravel Magellan is a modern **PostGIS toolbox for Laravel**.

It allows developers to work with spatial data like:

- Point
- Polygon
- LineString
- MultiPoint
- MultiPolygon

It also provides access to PostGIS functions like:

- ST_Distance
- ST_Buffer
- ST_Contains
- ST_Within
- ST_Area

Without writing raw SQL.

---

## Requirements

Before starting this project ensure you have:

- PHP 8.2+
- Composer
- Laravel 12
- PostgreSQL
- PostGIS Extension
- Node.js (optional)

---

## Step 1 — Create Laravel 12 Project

Run the following command:

```bash
composer create-project laravel/laravel PHP_Laravel12_Magellan "12.*"
```

Move into the project directory:

```bash
cd PHP_Laravel12_Magellan
```

Start the Laravel development server:

```bash
php artisan serve
```

---

## Step 2 — Configure PostgreSQL Database

This project uses **PostgreSQL with the PostGIS extension** to store and query spatial data.

### 2.1 Update Laravel Database Configuration

Edit the `.env` file:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=magellan_db
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

---

## 2.2 Create Database

Open **pgAdmin** or PostgreSQL terminal and run:

```sql
CREATE DATABASE magellan_db;
```

---

## Step 3 — Install PostGIS Extension (Windows)

Laravel Magellan requires **PostGIS** to be installed on PostgreSQL.

If PostGIS is not installed, the migration will fail with the error:

```
extension "postgis" is not available
```

Follow these steps to install it.

### 3.1 — Open Stack Builder

Search in Windows:

```
Stack Builder
```

Open:

```
Stack Builder (PostgreSQL 15)
```

---

### 3.2 — Select PostgreSQL Instance

You will see something like:

```
PostgreSQL 15 (x64) on port 5432
```

Select it and click:

```
Next
```

---

### 3.3 — Install Spatial Extensions

Navigate to:

```
Spatial Extensions
```

Select:

```
PostGIS 3.x Bundle for PostgreSQL 15
```

Example:

```
PostGIS 3.6 Bundle for PostgreSQL 15
```

Click:

```
Next → Next → Install
```

Wait until installation completes.

Then run migration command:

```bash
php artisan migrate
```

---

## Step 4 — Install Laravel Magellan

Install the package using composer.

```bash
composer require clickbar/laravel-magellan
```

---

## Step 5 — Publish Magellan Config

Publish config and migrations.

```bash
php artisan vendor:publish --tag="magellan-config"
```

```
php artisan vendor:publish --tag="magellan-migrations"
```

---

## Step 6 — Run Migrations

```bash
php artisan migrate
```

---

## Step 7 — Create Port Model

Create model and migration.

```bash
php artisan make:model Port -m
```

---

## Step 8 — Update Migration

Open:

```
database/migrations/create_ports_table.php
```

Modify it:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ports', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('country');

            // Spatial column (Magellan)
            $table->geometry('location', subtype: 'POINT', srid: 4326);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};
```

Run migration:

```bash
php artisan migrate
```

---

## Step 9 — Configure Port Model

Open:

```
app/Models/Port.php
```

Add geometry cast.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Clickbar\Magellan\Data\Geometries\Point;

class Port extends Model
{
    protected $fillable = [
        'name',
        'country',
        'location'
    ];

    protected $casts = [
        'location' => Point::class
    ];
}
```

---

## Step 10 — Create Controller

```bash
php artisan make:controller PortController
```

Open:

```
app/Http/Controllers/PortController.php
```

```php
<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;

class PortController extends Controller
{

    public function store()
    {

        Port::create([
            'name' => 'Mumbai Port',
            'country' => 'India',
            'location' => Point::makeGeodetic(18.9388, 72.8354)
        ]);

        return "Port created successfully";
    }

    public function nearbyPorts()
    {

        $currentLocation = Point::makeGeodetic(19.0760, 72.8777);

        $ports = Port::select()
            ->addSelect(
                ST::distanceSphere($currentLocation, 'location')->as('distance')
            )
            ->orderBy(
                ST::distanceSphere($currentLocation, 'location')
            )
            ->get();

        return $ports;
    }
}
```

---

## Step 11 — Define Routes

Open:

```
routes/web.php
```

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortController;

Route::get('/create-port',[PortController::class,'store']);

Route::get('/nearby-ports',[PortController::class,'nearbyPorts']);
```

---

## Step 12 — Test Application

Create port:

```
http://127.0.0.1:8000/create-port
```

Find nearby ports:

```
http://127.0.0.1:8000/nearby-ports
```

---

## Output

<img width="1821" height="1081" alt="Screenshot 2026-03-12 130553" src="https://github.com/user-attachments/assets/33c91c48-6ef3-4b3d-ac5c-1224bffbfa67" />

<img width="1825" height="1085" alt="Screenshot 2026-03-12 141116" src="https://github.com/user-attachments/assets/e8822e7b-238c-42fd-93d4-87ab69a21359" />

---

## Project Structure

```
PHP_Laravel12_Magellan
│
├── app
│   ├── Http
│   │   └── Controllers
│   │       └── PortController.php
│   │
│   └── Models
│       └── Port.php
│
├── database
│   └── migrations
│       └── create_ports_table.php
│
├── routes
│   └── web.php
│
├── config
│   └── magellan.php
│
├── .env
│
└── composer.json
```

---

## Example Spatial Data

| Port            | Country   | Latitude | Longitude |
|-----------------|-----------|----------|-----------|
| Mumbai Port     | India     | 18.9388  | 72.8354   |
| Singapore Port  | Singapore | 1.3521   | 103.8198  |

---

Your PHP_Laravel12_Magellan Project is now ready!
