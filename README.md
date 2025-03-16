# Social Post Automation

This project automates the creation of social media posts based on partner and post template data. Developed by **Oleksandr Kolomiiets**.

---

## Installation and Setup

**Install dependencies**:
   ```
   composer install
   ```

**Run database migrations**:
   ```
   php artisan migrate
   ```

---

## Import Commands

You can import data for **Partners** and **Post Templates** using the following commands:

- **Import Partners** (from `partners.csv`):
  ```
  php artisan app:import-partners
  ```

- **Import Post Templates** (from `posts.csv`):
  ```
  php artisan app:import-post-templates
  ```

These commands are designed so that the import logic can be extended or reused for other files in the future.

---

## Event-Driven Approach

The application follows an event-driven architecture:

- **PartnerCreated** event triggers the **GeneratePostForPartner** listener
- **PostTemplateCreated** event triggers the **GeneratePostForTemplate** listener

Both listeners dispatch a **GeneratePost** event.

**Note:** Posts will only be created if **all** placeholders exist and match correctly. Posts with missing or invalid placeholders are skipped to avoid user experience issues. This logic is handled within the `PostService`.

---

## File Data Validation

Validation is performed through dedicated services:

- **PartnerImportValidator**
- **PostTemplateImportValidator**

These ensure that the CSV data is correct before further processing or database insertion.

---

## Repository Layer

`PostRepository` is used to encapsulate data operations and allow for easier scalability. If the project grows and must handle large volumes of data, the repository pattern helps keep data layer changes isolated.

---

## Technical Debt / Future Improvements

1. **Use UUIDs for Partners**  
   Replace the numeric `id` with a UUID to avoid exposing internal record identifiers.
2. **Add Authorization**  
   Secure API endpoints with appropriate authentication and authorization mechanisms.
3. **Import Chunks**  
   When handling larger files, process data in chunks to prevent memory overload.
4. **Enhanced Logging and Monitoring**  
   Improve observability and auditing around data imports and post generation.
