# 🎬 Movie Explorer System

A dynamic PHP + MySQL web application that allows users to **explore**, **search**, and **save favorite movies** using the [OMDb API](http://www.omdbapi.com/). Designed with a clean Bootstrap 5 UI and secured login system.

---

## 🧠 Project Description

This web application enables users to:
- 🔍 Search for movies by name or genre
- 🎞️ View movie details including rating, plot, cast, genre
- 🔐 Register/Login securely with form validation
- ❤️ Save favorite movies
- 🗑️ Remove from favorites anytime
- 🧑 View and update user profile
- 🔒 Change password
- 🌟 Filter movies by IMDb rating

All movie data is fetched using the **OMDb API**, and user data is securely stored in **MySQL**.

---

## 🛠️ Technologies Used

- **Frontend**:  
  - HTML5  
  - CSS3  
  - Bootstrap 5  
  - Animate.css (for animation)  
- **Backend**:  
  - PHP 8  
  - MySQL (phpMyAdmin)  
- **API**:  
  - OMDb API (http://www.omdbapi.com/)
- **Other Tools**:  
  - XAMPP / WAMP / MAMP (for local server)

---

## 🖼️ Screenshots
### 🔐 Home Page
![image](https://github.com/user-attachments/assets/70738c87-31a1-48b9-a91a-d18847f63885)

### 🎬 Search Results
![image](https://github.com/user-attachments/assets/d19817ea-236c-44a6-a9b0-83b5a56dc9d4)

### 📄 Movie Details
![image](https://github.com/user-attachments/assets/ffc2134b-c82d-4106-958f-a167b1b1da69)

### ❤️ Favorites Page
![image](https://github.com/user-attachments/assets/785420d7-2ba4-447f-bfd3-350a8652ae36)

## 🧑‍💻 How to Run This Project Locally

### 🔧 Prerequisites
- [XAMPP](https://www.apachefriends.org/) / WAMP / MAMP installed
- PHP and MySQL enabled

---

### 🛠️ Setup Instructions

1. **Clone the Repository**

```bash
git clone https://github.com/yourusername/movie-explorer-system.git

2. **Move Project to XAMPP Directory**
# On Windows
Move to: C:/xampp/htdocs/movie-explorer-system/

# On macOS (MAMP)
Move to: /Applications/MAMP/htdocs/movie-explorer-system/

**3. Start Apache & MySQL in XAMPP Control Panel**

**4. Create Database in phpMyAdmin**

Open browser → http://localhost/phpmyadmin

**5. Create new database named movie_explorer**

Run the following SQL:
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE favorites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  imdb_id VARCHAR(20),
  title VARCHAR(255),
  poster TEXT,
  rating VARCHAR(10),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

**6. Access the App**

Open your browser:
http://localhost/movie-explorer-system/

🙌 Credits
**OMDb API**

**Bootstrap 5**

**Animate.css**

📧 Contact
Developer: Gaurav Bhuravane
📮 Email: bhuravanegaurav123@gmail.com
🔗 GitHub: @gauravbhuravane

⭐ If you like this project, don’t forget to star the repo and contribute!




