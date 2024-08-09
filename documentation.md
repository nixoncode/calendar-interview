## Calendar Events API Documentation

The Calendar Events API allows you to manage calendar events stored in a database. It provides endpoints to:

- **Fetch events**: Retrieve events, optionally filtered by calendar type.
- **Add events**: Create new events with details like title, start/end dates, URL, and extended properties.
- **Update events**: Modify existing events based on their ID.
- **Delete events**: Remove events from the database.

The API uses JSON for data exchange and follows standard HTTP methods and status codes for communication. It's designed
to be integrated with a frontend calendar application, enabling seamless event management and synchronization.

## Getting Started

### Prerequisites

* PHP (version 7.4 or higher)
* MySQL or a compatible database server
* A local web server (e.g., Apache, Nginx, or PHP's built-in server)

### Installation

1. **Clone the repository:**

```bash
  git clone git@github.com:nixoncode/calendar-interview.git
```


2. **Modify Database connection properties**

Open `db_connect.php` and update the following variables with your actual database credentials:

```php
    $db_host = 'localhost';
    $db_name = 'vesen_calendar';
    $db_user = 'nixon';
    $db_pass = 'password';
```

3. **Launch a local PHP server**
    - Navigate to the project directory in your terminal
    - Run the below command
    ```shell
      php -S localhost:8000
    ```
    - Alternatively, you can use Xampp or Mamp if that's your thing
    - Or even if you're using Apache or Nginx, configure your virtual host to point to the project directory

4. **Access the API**
    - Open your web browser and visit http://localhost:8080 (or the appropriate URL based on your server configuration).
      You should see the calendar frontend, and the API endpoints will be accessible at 
   http://localhost:8080/fetch_events.php, http://localhost:8080/add_event.php, e.t.c


### Base URL

> http://localhost:8080

(Replace with the actual domain or IP address where your API is hosted)

### Endpoints

#### 1. Fetch Events

- **Endpoint:** `/fetch_events.php`
- **Method:** `GET`
- **Description:** Retrieves calendar events from the database.
- **Query Parameters:**
    * `none`
- **Response (Success — 200 OK):**

  ```json
  [
    {
        "id": 1,
        "title": "Design Review",
        "calendar": "Business",
        "start": "2024-08-09 11:37:43",
        "end": "2024-08-10 11:37:43",
        "url": "",
        "allDay": false,
        "extendedProps": {
            "calendar": "Business",
            "description": null,
            "guests": ["Alex", "James"],
            "location": null
        }
    }
  ]
  ```
- **Response (Error):**

  ```json
  {
      "error": "Error message" 
  }
  ```

  - Possible error HTTP status codes:
    - 405 — Method Not Allowed
    - 500 — Internal Server Error

#### 2. Add Event

* **Endpoint:** `/add_event.php`
* **Method:** `POST`
* **Description:** Adds a new calendar event to the database.

* **Request Body:**

  ```json
  {
      "title": "Event Title",
      "start": "2024-08-20 14:30:00",
      "end": "2024-08-20 16:00:00",
      "url": "https://www.example.com", // optional
      "allDay": false, // `default: false
      "calendar": "Personal", 
      "description": "Event description", // optional
      "guests": ["John Doe", "Jane Smith"], // optional
      "location": "Conference Room A" // optional
  }
  ```

* **Response (Success — 201 Created):**

  ```json
  {
      "message": "Event added successfully",
      "id": 12 // ID of the newly created event
  }
  ```

* **Response (Error):**

  ```json
  {
      "error": "Error message" 
  }
  ```

    * Possible error HTTP status codes:
        * 400 — Bad Request
        * 405 — Method Not Allowed
        * 500 — Internal Server Error

#### 3. Update Event

* **Endpoint:** `/update_event.php`
* **Method:** `PUT`
* **Description:** Updates an existing calendar event in the database

* **Query Parameters:**
    * `id`: ID of the event to update.

* **Request Body:**

  ```json
  {
      "title": "Updated Event Title",
      "start": "2024-08-22 10:00:00",
      "end": "2024-08-22 12:00:00",
      "url": "https://example.com/zoom", // optional
      "allDay": true,
      "calendar": "Business",
      "description": "Updated event description", // optional
      "guests": ["Alice", "Bob"], // optional
      "location": "Online Meeting" // optional
      
  }
  ```

* **Response (Success — 200 OK):**

  ```json
  {
      "message": "Event updated successfully"
  }
  ```

* **Response (Error):**

  ```json
  {
      "error": "Error message" 
  }
  ```

  - Possible error HTTP status codes:
    - 400 — Bad Request
    - 404 — Not Found (if the event with the given ID doesn't exist)
    - 405 — Method Not Allowed
    - 500 — Internal Server Error

#### 4. Delete Event

- **Endpoint:** `/delete_event.php`
- **Method:** `DELETE`
- **Description:** Deletes a calendar event from the database.

- **Query Parameters:**
  - `id`: ID of the event to delete

- **Response (Success — 200 OK):**

  ```json
  {
      "message": "Event deleted successfully"
  }
  ```

- **Response (Error):**

  ```json
  {
      "error": "Error message" 
  }
  ```

  - Possible error HTTP status codes:
    - 400 Bad Request
    - 404 — Not Found (if the event with the given ID doesn't exist)
    - 405 — Method Not Allowed
    - 500 — Internal Server Error

**Additional Notes:**

- **Authentication/Authorization:** Not implemented
* **Error Handling:** Basic using http methods and uniform JSON interface

* **Examples:** Look inside `assets/js/app-calendar.js`

