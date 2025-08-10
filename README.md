# home-test


## Project Overview

This project is maintained in Git. You can clone or pull the latest version from your repository to get all the features and updates.

---

## Features Overview

This project includes the following key features:

1. **Login Page with OTP**
   - User enters username.
   - Server sends an OTP via Brevo.com API (email) valid for 10 minutes.
   - Rate limits: max 4 OTPs per hour, 10 per day.
   - On successful login, server returns a token for subsequent requests.

2. **Emoji Picker**
   - Emoji button next to message input.
   - Clicking button opens emoji picker.
   - Selected emoji inserted into message input.
   - Single-emoji messages display larger in chat.

3. **Image Upload**
   - Click paperclip icon to open file dialog for image selection.
   - Drag & drop images into chat window to upload.
   - Selected images preview before sending.
   - Images uploaded to server folder: `uploaded_files`.
   - Server-side validation and secure saving of images.

4. **Delete Message (For Both Sides)**
   - Delete button/icon next to each message.
   - Deleting removes message from database for both sender and receiver.
   - Server handles secure deletion.

---

## Running the Project Locally

1. Clone your Git repository if you haven't already:

```bash
   git clone https://your-repo-url.git
   cd your-repo-folder
```
2. Start the PHP built-in server (adjust path accordingly):
```bash
    php -S localhost:8000 -t .
```
3. Open your browser to:

```
http://localhost:8000/index.php
```

### How to Run the Login App
1. Go to the login-app library:
```bash 
    cd login-app
```
2. Install dependencies run:
```bash
    npm install
```
3. To run the app:
```bash
    npm install
```

---
## Environment Variables Setup
Create a .env file in the project root with:

```.env
API_KEY=your_brevo_api_key_here
SENDER_NAME=YourAppName
SENDER_EMAIL=your_email@example.com
```