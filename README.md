# Idea Bookstore

A responsive, secure multi-tier e-commerce web application built for **CSC-30025 Advanced Web Technologies** at Keele University.

The project explores three main areas of software development:

* **UI/UX and responsive web design**
* **Full-stack MVC application architecture**
* **Web security and robust data handling**

Users can browse books, filter the catalogue, register, authenticate, place orders and review their order history. Administrative users can search and filter order data and access REST-style JSON endpoints.

## Project Highlights

* Responsive bookstore interface designed around established e-commerce UX patterns
* PHP MVC architecture with specialised controllers and models
* MySQL relational database with normalised entities and foreign-key relationships
* React-powered registration with real-time validation
* AJAX catalogue filtering without full-page refreshes
* REST-style JSON endpoints
* Session-based authentication and role-protected routes
* Prepared statements, password hashing and output escaping
* Responsive layouts across desktop, tablet and mobile
* **100 Lighthouse scores for Performance, Accessibility, Best Practices and SEO**

---

# UI / UX Design

UI/UX was an important part of the project rather than simply styling the finished application.

Before implementation, I reviewed navigation and interaction patterns used by established online bookstores including **Waterstones, World of Books and AwesomeBooks**.

I then adapted useful patterns rather than reproducing the sites directly.

## Navigation Design

One of the main design decisions was to create a compact navigation system based around:

* **Kids**
* **Adults**
* **Shop**
* **Account**

Instead of displaying separate Login and Register navigation entries, authentication-related functionality is grouped under **Account**.

This reduces navigation clutter and follows a pattern commonly used by established e-commerce websites.

### Category Navigation

The shop supports a two-level information hierarchy.

```text
Kids
├── Infants
├── Junior
└── Young

Adults
├── Classic Novels
├── Fiction
├── Comic
└── Crime & Thriller
```

Each dropdown option contains both a title and a short description.

For example:

```text
Classic Novels
Timeless literature and essential reads
```

This gives the user additional context before selecting a category instead of relying only on short category labels.

Dropdown chevrons rotate when menus open, providing additional visual feedback.

---

## Progressive Interface Complexity

I intentionally used different filtering approaches for customers and administrators.

### Customer interface

The customer-facing shop uses simplified navigation through the main header.

The aim was to minimise interface complexity and allow users to reach book categories quickly.

### Administrator interface

Administrators receive more detailed controls, including:

* Main category filtering
* Subcategory filtering
* Order lookup
* REST API lookup
* Reset controls

This reflects the different requirements of the two user groups.

Customers benefit from a simpler browsing interface, while administrators need greater information density and control.

---

# Visual Design System

The application uses a consistent blue/yellow identity inherited from an earlier **Idea Company** project.

The main design tokens include:

```css
--idea-blue: #0058A3;
--idea-blue-dark: #003B73;
--idea-yellow: #FFDA1A;
--off-white: #F7F9FC;
--text-dark: #1F2937;
--text-light: #5B6470;
--border: #D9E2EC;
```

Using shared design values helps maintain consistency between:

* Navigation
* Product cards
* Authentication
* Buttons
* Administration interfaces
* Form feedback

The custom **Meowchie** mascot and blue/yellow palette were retained to provide a consistent visual identity across related projects.

---

# Responsive Design

The interface was designed to adapt progressively across different screen sizes.

## Catalogue Grid

The book catalogue changes from:

```text
Desktop       5 columns
Large screen  4 columns
Tablet        3 columns
Small tablet  2 columns
Mobile        2 columns
Very small    1 column
```

Rather than scaling the desktop page down directly, card dimensions, typography, image heights, padding and gaps are adjusted at different breakpoints.

This keeps the catalogue readable and usable on smaller devices.

---

## Responsive Navigation

On desktop, the primary navigation is displayed horizontally.

On smaller screens it changes to a mobile navigation menu controlled by a hamburger button.

The JavaScript also updates:

```html
aria-expanded
```

when the navigation opens or closes so that the interface state is available to assistive technologies.

---

# Product Card Design

Books are presented using consistent cards containing:

* Cover image
* Title
* Author
* Genre
* Category
* Subcategory
* Price
* Primary action

Cards use consistent spacing, typography and hierarchy so that information can be scanned quickly.

Book titles are constrained to prevent unusually long titles from breaking the grid.

The price is visually separated from the descriptive content and positioned near the primary action.

Cards also provide subtle hover feedback:

```text
Default
   ↓
Hover
   ↓
Card rises slightly
Shadow becomes stronger
Border changes to yellow
```

The intention was to indicate interactivity without using excessive animation.

---

# Context-Aware Actions

The primary product action changes depending on authentication state.

Unauthenticated users see:

```text
Login to Order
```

Authenticated users see:

```text
Order Now
```

This makes the next required action explicit rather than allowing an unauthenticated order attempt and displaying an error afterwards.

---

# Asynchronous User Experience

Book filtering uses AJAX so users can move between categories without reloading the entire page.

```javascript
let url = "index.php?action=fetchBooks";

url += "&category=" + encodeURIComponent(category);
```

The server returns JSON and JavaScript dynamically updates the product grid.

During the request, the interface displays:

```text
Please wait...
```

Error and empty-result states are also handled:

```text
Error loading books.

No books available.
```

The status area uses:

```html
aria-live="polite"
```

so dynamic messages can also be announced by compatible assistive technologies.

This combination improves perceived responsiveness while retaining clear system feedback.

---

# Form UX

Registration was implemented as a React component with real-time validation.

Fields include:

* Username
* Phone number
* Email
* Email confirmation
* Password
* Password confirmation

## Live Validation

Validation occurs while the user interacts with the form rather than waiting until the complete form has been submitted.

The interface provides clear valid and invalid states.

```text
Normal field
      ↓
User input
      ↓
Validation
   ↙       ↘
Valid     Error
```

Email availability is also checked asynchronously.

Example states include:

```text
Checking email...
Email available.
Email already in use.
```

Server-side validation is still repeated because client-side validation can be bypassed.

---

## Floating Labels

Authentication forms use floating labels.

When the field receives focus or contains a value, the label moves above the input.

This preserves the field description while avoiding the ambiguity that can occur when placeholder text disappears after typing.

Focused fields also receive a visible focus treatment to indicate the currently active control.

---

# Feedback and Error Handling

The application distinguishes between error and success states using both text and visual styling.

Examples include:

* Invalid registration input
* Successful registration
* Invalid authentication
* CAPTCHA errors
* Email availability
* AJAX loading failures
* Empty catalogue results

This ensures users receive immediate feedback about the result of their actions.

---

# Accessibility Considerations

Accessibility-related implementation includes:

* Semantic `<nav>`, `<main>`, `<section>` and `<article>` elements
* Navigation `aria-label`
* Mobile navigation `aria-expanded`
* `aria-controls`
* `aria-live` for asynchronous catalogue status
* Descriptive image alternative text
* Visible keyboard focus states
* Responsive layouts
* Clear visual hierarchy
* Text labels retained for form controls

Book cover alternative text is generated dynamically using available book information.

For example:

```text
Book cover for [title] by [author]
```

rather than simply using:

```text
image
```

---

# Architecture

The backend uses the **Model-View-Controller (MVC)** architectural pattern.

```text
                 Browser
                    │
                    ▼
                index.php
             Front Controller
                    │
        ┌───────────┼────────────┐
        ▼           ▼            ▼
Authentication   Book        Admin / Orders
 Controller    Controller      Controller
        │           │            │
        └───────────┼────────────┘
                    ▼
                  Models
                    │
                    ▼
                  MySQL
```

The application was refactored from an earlier structure into specialised components such as:

```text
Controller/
├── AdminController.php
├── AuthenticationController.php
├── BookController.php
├── CustomerOrdersController.php
└── MainController.php

Model/
├── BookModel.php
├── CaptchaModel.php
├── CustomerOrdersModel.php
├── DB_Connection.php
├── EnvLoader.php
└── UserAccountsModel.php

View/
├── Pages/
├── authentication/
└── layouts/
```

This separation improved maintainability and reduced the amount of unrelated functionality contained within individual files.

---

# Technology Stack

## Backend

* PHP
* MySQL
* MVC architecture

## Frontend

* HTML5
* CSS3
* JavaScript
* React
* AJAX / XMLHttpRequest
* Fetch API

## Other

* REST-style JSON endpoints
* Git
* Lighthouse
* Environment-based configuration

---

# Database Design

The main relational entities are:

```text
Accounts
    │
    │ 1:N
    ▼
Orders
    │
    │ N:1
    ▼
Products

CaptchaImages
```

### Accounts

Stores:

* Username
* Phone
* Email
* Password hash
* Administrator status

### Products

Stores:

* ISBN
* Title
* Author
* Genre
* Category
* Subcategory
* Price
* Stock
* Image

### Orders

Links users and products using foreign keys rather than duplicating their data.

### CAPTCHA Images

Stores CAPTCHA image and answer information used during authentication.

---

# Security

The application implements multiple layers of web security.

## SQL Injection

Database access uses prepared statements and parameter binding.

```php
$stmt = $this->connection->prepare($sql);
$stmt->bind_param("s", $email);
```

## Password Storage

Passwords are hashed using:

```php
password_hash($password, PASSWORD_DEFAULT);
```

Authentication uses:

```php
password_verify($password, $user['password']);
```

Plain-text passwords are therefore not stored or directly compared.

## Cross-Site Scripting

Dynamic output is escaped before being rendered.

```php
echo htmlentities(
    $order['title'],
    ENT_QUOTES,
    'UTF-8'
);
```

JavaScript-generated product content is also escaped before insertion into the DOM.

## Sessions

Authentication state is stored server-side using PHP sessions.

Following successful authentication:

```php
session_regenerate_id(true);
```

is used to issue a new session identifier.

Protected routes use authentication and administrator checks.

## Configuration

Database credentials are loaded from an environment configuration rather than being embedded directly throughout application source code.

---

# REST-Style API

Administrative order information can be requested through JSON endpoints.

For example:

```text
index.php?action=apiOrder&id=3
```

This allows application data to be retrieved independently of HTML rendering and demonstrates separation between data and presentation.

---

# Testing

The project was tested for:

* Functional behaviour
* SQL injection
* Cross-site scripting
* Authentication
* Session enforcement
* CAPTCHA behaviour
* Responsiveness
* Performance
* Accessibility
* SEO

## Security Testing

SQL injection payloads were tested against:

* Login
* Registration
* AJAX requests
* URL parameters

XSS testing included standard, URL-based and encoded payloads.

Protected routes were also accessed without authentication to confirm session enforcement.

---

# Lighthouse

Google Lighthouse testing achieved:

| Category       |   Score |
| -------------- | ------: |
| Performance    | **100** |
| Accessibility  | **100** |
| Best Practices | **100** |
| SEO            | **100** |

Reported metrics also included:

* **First Contentful Paint:** 0.3 s
* **Largest Contentful Paint:** 0.4 s
* **Total Blocking Time:** 0 ms
* **Cumulative Layout Shift:** 0
* **Speed Index:** 0.3 s

---

# Engineering Challenges

## Refactoring the MVC Structure

The initial implementation became harder to maintain as functionality increased.

Rather than continuing to extend larger scripts, I refactored the project into specialised controllers and models.

This improved:

* Separation of concerns
* Maintainability
* Code organisation
* Extensibility

---

## React Deployment Constraints

The original intention was to use a conventional React dependency setup.

The university server restricted the required dependency installation, so I adapted the implementation to use browser-compatible React scripts while retaining the required real-time registration functionality.

This demonstrated the importance of adapting software to deployment constraints rather than assuming the development environment will always match the initial design.

---

## Balancing Navigation Complexity

The coursework required detailed two-level category filtering.

I decided not to expose the same level of complexity everywhere.

The administrator interface retained detailed filtering controls, while customer navigation was simplified around category dropdowns.

This was a deliberate UX decision: **the interface should reflect the user's task rather than expose every capability simply because it exists.**

---

# Future Improvements

Potential improvements include:

* Full catalogue management interface
* Product creation and editing
* Live stock reduction
* Payment integration
* Email order confirmation
* Automated testing
* Compiled React frontend
* Improved search functionality
* Featured and newly added books
* Further accessibility testing
* Additional REST API endpoints

---

# What I Learned

This project developed my experience across both engineering and product design.

### Software Engineering

* MVC architecture
* Relational database design
* Refactoring
* REST-style APIs
* Asynchronous communication
* Authentication and sessions
* Security testing

### Frontend / UX

* Responsive interface design
* Information hierarchy
* E-commerce navigation patterns
* User feedback and error states
* Progressive interface complexity
* Form usability
* Accessibility
* Consistent visual systems

### Development Practice

* Adapting to technical constraints
* Testing assumptions
* Separating application responsibilities
* Designing around user tasks
* Balancing usability, maintainability, performance and security

---

**Thomas Higginson**
BSc Computer Science — Keele University
