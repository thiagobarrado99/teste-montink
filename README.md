# Montink Challenge:

Build a "Mini ERP" to manage Orders, Products, Coupons and Inventory.

## Requested Tech Stack:

- DB: MySQL
- Frontend: Bootstrap
- Backend: Plain PHP, CodeIgniter 3 or Laravel

## Used Tech Stack:

- DB: MariaDB 10.4.32
- Frontend: Bootstrap 5
- Backend: Laravel 12.20.0 running on PHP 8.4.10
- Additional: Node v20.19.3 with NPM v10.8.2 (Not required to run the project)

## Required Features:

- DB should have at least 4 tables: **Orders**, **Products**, **Coupons** and **Inventory**;
- Dashboard to create, update and delete products with fields **_Name_**, **_Price_**, **_Variations_** and **_Inventory_**;
- After creation, a new **Inventory** instance should be created for the **Product** ( 1 - 1 relation );
- There should be another page for purchasing products, and the cart should be stored in session (must contain quantities and prices);
- The shipping cost should be calculated based on the total cart price, using the logic below:

| Cart price range ($)    | Shipping cost ($) |
|-------------------------|-------------------|
| Less than 52            | 20                |
| 52 to 166.59            | 15                |
| 166.60 to 200           | 20                |
| More than 200           | 0 (free)          |

- Zipcode should be verified using ViaCEP REST APIs ( https://viacep.com.br/ ).

## Bonus Features:

- Product variations;
- Coupon CRUD: Coupons should have expiration date and a minimum cart price to apply;
- Notifications (via email) after order confirmation;
- REST API (Mistakenly called "Webhook" in the original document) to update orders status.

## Not required or bonus, but important features:

- A good frontend isn't mandatory, but will be taken into account;
- Use MVC, Clean Code and Coding Best Practices;
- Keep a simple codebase that solves the main problem and is maintainable;
- Don't overengineer;
- Handle common problems that may appear from user interaction.

## Important notes from the developer:

- Since the challenge was quite easy and simple, I built some extra features that weren't asked, such as:
    - Database fully managed by migrations
    - Admin dashboard protected by login/password
    - Inventory history
    - Coupon max uses along with expiration date
    - Shipping cost rules
- I really **_prefer_** using strict SOLID standards, but since it was asked to not overengineer, I won't be strictly using it in this project.
- I decided on MariaDB instead of MySQL because it's easier, free and open-source, but since they share the same codebase and syntax, this project works on both.
- Though Node and NPM aren't required to run this project, it's a better approach for running a Laravel project locally since Node will handle the queues.
- And lastly, I decided to not make the CRUDs and the user frontend/cart on the same page, for both security and common standards/design patterns.
