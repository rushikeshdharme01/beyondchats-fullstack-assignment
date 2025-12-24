# BeyondChats – Technical Product Manager Assignment

This repository contains my submission for the **Full Stack Engineer / Technical Product Manager (Fresher)** role at **BeyondChats**.

The goal of this assignment was to demonstrate:
- System thinking
- Backend + frontend integration
- Practical scraping & API design
- Ability to ship under time constraints

---

## 🧩 Project Overview

The project is divided into **three parts**, as requested:

1. **Laravel Backend**
   - Scrapes the 5 oldest BeyondChats blog articles
   - Stores them in a database
   - Exposes full CRUD APIs

2. **React Frontend**
   - Fetches articles from Laravel APIs
   - Displays original and generated articles
   - Responsive, clean UI

3. **Node.js + AI (Partial – Planned)**
   - Reads latest article from backend
   - Finds competitor articles via Google search
   - Uses LLM to rewrite/improve content
   - Publishes updated article via API

> Note: Due to time constraints, Phase 2 is partially implemented and documented with clear design decisions.

---

## 🏗️ Tech Stack

### Backend
- Laravel 9
- PHP 8
- MySQL
- Guzzle HTTP Client
- Symfony DomCrawler

### Frontend
- React (Create React App)
- Fetch API
- CSS (Responsive grid layout)

### AI / Automation (Planned)
- Node.js
- OpenAI API
- Google Search (SerpAPI / Custom Search)

---

## 🔄 System Architecture & Data Flow

### Phase 1: Scraping & Storage
1. Laravel fetches BeyondChats blogs page
2. Extracts blog URLs and selects the 5 oldest articles
3. Scrapes article title and content
4. Stores them in the `articles` table with:
   - title
   - content
   - source_url
   - source_type = `original`

### Phase 2: AI Content Update (Planned)
1. Node.js fetches latest article from Laravel API
2. Searches Google for similar ranking articles
3. Scrapes top 2 competitor blogs
4. Sends content to LLM for rewriting
5. Publishes updated article via Laravel API
6. References competitor articles at the bottom

### Phase 3: Frontend
1. React app calls `/api/articles`
2. Displays articles in cards
3. Highlights original vs generated articles

---

## 🗄️ Database Schema

**articles table**

| Column | Type |
|------|------|
| id | bigint |
| title | string |
| content | longText |
| source_url | string |
| source_type | enum (original, generated) |
| reference_urls | json (nullable) |
| created_at | timestamp |
| updated_at | timestamp |

---

## 🔌 API Endpoints

### Scraping
- `GET /api/scrape-articles`  
  Scrapes and stores the 5 oldest BeyondChats articles.

### CRUD APIs
- `GET /api/articles` – List all articles
- `GET /api/articles/{id}` – Get single article
- `POST /api/articles` – Create article
- `PUT /api/articles/{id}` – Update article
- `DELETE /api/articles/{id}` – Delete article

---

## 🖥️ Local Setup Instructions

### 1. Clone Repository
```bash
git clone <your-repo-url>
cd beyondchats-assignment





2. Backend Setup
cd backend-laravel/beyondchats-backend
composer install
php artisan key:generate
php artisan migrate
php artisan serve



3. Frontend Setup
cd frontend-react/beyondchats-frontend
npm install
npm start



🌐 Live Links

Frontend (React): Netlify deployment (to be added)

Backend (API): Localhost (development)


⚖️ Trade-offs & Design Decisions

Prioritized a stable backend and clean data pipeline over complex AI orchestration.

Used Create React App to minimize tooling overhead and improve reliability.

Focused on correct scraping and API structure before AI-generated content.

Phase 2 is partially implemented by design, reflecting realistic time constraints.


🧪 Evaluation Alignment

This submission focuses on:

Backend completeness and data correctness

Clear system design and architecture

Proper documentation and setup clarity

Conscious engineering trade-offs over forced completeness



🙋‍♂️ Final Notes

This project reflects how I approach real-world problems:

Build incrementally

Make conscious trade-offs

Prioritize clarity and reliability

Thank you for reviewing my submission.

— Rushikesh Dharme