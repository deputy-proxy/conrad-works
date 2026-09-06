# Role Domains

The app models each role as a first-class `MyRole` record. `MyRole` contains presentation metadata and has many `MyRoleRepresentative` records.

A representative stores a **model class**, not a model instance. It has no `model_id` and therefore does not point at a specific Venture, Book, Article, etc.

## Structure

- Human -> Habit
- Husband -> WifeMessage
- Father -> DaughterMessage
- Consultant -> BookableSlot
- Entrepreneur -> Venture
- Writer -> Book + Article
- Trainer -> Course
- Songwriter -> Song

The actual user's records remain in their respective domain tables. `MyRoleRepresentative` is the configuration/curation layer telling the UI which model types should represent a role.

## Filament

`MyRoleResource` manages role metadata. Its Representative Models relation manager lets you select one or more supported Eloquent model classes for each role.

Supported model classes are centralized in `App\\Support\\RoleRepresentativeModels`.

## Setup

```bash
composer install
php artisan migrate:fresh --seed
npm install
npm run dev
```
