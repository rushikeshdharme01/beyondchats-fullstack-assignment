# BeyondChats – Full Stack & AI Content System

This repository contains my submission for the **Full Stack Engineer / Technical Product Manager (Fresher)** role at **BeyondChats**.

The objective of this assignment was to demonstrate:
- End-to-end system thinking
- Backend–frontend integration
- Practical scraping & API design
- Ability to ship reliable software under time constraints

---

## 🧩 Project Overview

The system is divided into **three logical phases**, as requested:

### 1. Laravel Backend (Core System)
- Scrapes the 5 oldest BeyondChats blog articles
- Normalizes and stores structured content in MySQL
- Exposes RESTful CRUD APIs
- Acts as the single source of truth for content

### 2. Node.js + AI Pipeline (Minimal Implementation)
- Fetches the latest article from Laravel APIs
- Collects competitor references (mocked / configurable)
- Generates an improved version using an LLM-style workflow
- Publishes generated content back to Laravel as a new article

> Phase 2 is intentionally minimal but functional, prioritizing correctness and extensibility over excessive orchestration.

### 3. React Frontend
- Fetches articles from the Laravel API
- Displays original vs generated articles distinctly
- Deployed as a static frontend for fast delivery

---

## 🏗️ Tech Stack

### Backend
- Laravel 9
- PHP 8
- MySQL
- Guzzle HTTP Client
- Symfony DomCrawler
- Docker (production)

### Frontend
- React (Create React App)
- Fetch API
- Responsive CSS

### AI / Automation
- Node.js
- LLM-style text generation workflow
- Extensible for OpenAI / Gemini / Claude APIs

---

## 🔄 System Architecture

[ React (Netlify) ]
|
v
[ Laravel API (Render) ]
|
v
[ MySQL Database (Railway) ]

[ Node.js AI Service ]
|
v
[ Laravel API ]



---

## 🔄 Data Flow

### Phase 1: Scraping & Storage
1. Laravel scrapes BeyondChats blog listing
2. Extracts valid article URLs
3. Scrapes title & content
4. Stores articles with `source_type = original`

### Phase 2: AI Content Enhancement
1. Node.js fetches the latest article
2. Generates an improved version (simulated LLM workflow)
3. Saves new article with:
   - `source_type = generated`
   - `reference_urls`

### Phase 3: Presentation
1. React frontend calls `/api/articles`
2. Displays articles with clear labeling
3. Separates original vs generated content visually

---

## 🗄️ Database Schema

**articles**

| Column | Type |
|------|------|
| id | bigint |
| title | string |
| content | longText |
| source_url | string |
| source_type | enum (`original`, `generated`) |
| reference_urls | json (nullable) |
| created_at | timestamp |
| updated_at | timestamp |

---

## 🔌 API Endpoints

### Scraping
- `GET /api/scrape-articles`  
  Scrapes and stores the 5 oldest BeyondChats articles.

### Articles CRUD
- `GET /api/articles`
- `GET /api/articles/{id}`
- `POST /api/articles`
- `PUT /api/articles/{id}`
- `DELETE /api/articles/{id}`

---

## 🖥️ Local Setup

### 1. Clone Repository
```bash
git clone https://github.com/your-username/beyondchats-fullstack-assignment.git
cd beyondchats-fullstack-assignment


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


4. AI Service
cd ai-node
npm install
node index.js



🌐 Live Deployment

Frontend (Netlify)
https://fullstack-and-ai-content-sytem.netlify.app/

Backend API (Render)
https://beyondchats-fullstack-assignment.onrender.com/

Database
Railway Cloud MySQL



⚖️ Trade-offs & Design Decisions

Prioritized a stable backend pipeline over complex AI orchestration

Used CRA for predictable frontend behavior

Implemented AI pipeline minimally but correctly

Focused on correctness, clarity, and extensibility

🧪 Evaluation Alignment

This submission emphasizes:

Backend completeness

Clear system design

Production-style deployment

Honest engineering trade-offs



🙋‍♂️ Final Notes

This project reflects how I approach real-world problems:

Build incrementally

Deploy early

Make conscious trade-offs

Optimize for reliability and clarity

Thank you for reviewing my submission.

— Rushikesh Dharme