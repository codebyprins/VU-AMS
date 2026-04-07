# VU-AMS
Herontwerpen en verbeteren van de bestaande website.

## Languages and Tools
- WordPress
- Tailwind v3.4
- Vite
- Docker/localWP

## WordPress plugins
- Fastest WP cache
- Post Types Order
- Duplicator
- ACF (free)
- ACF Fontawesome
- Yoast SEO

## Branches
main – Deze wordt op een live omgeving gezet.

develop – Hier komen de branches bij elkaar om getest te worden

feature/xyz – Individuele functies (denk aan secties en algemene functies)

hotfix/xyz – Snelle fixes van features.

## Workflow
npm run build
Feature -> testen -> Develop -> testen -> Main -> testen -> edit app.css versie nummer -> live

## Branch Naming Convention:
feature/short-description
hotfix/short-description

## Clone the repository:
git clone https://github.com/your-username/your-repo.git

Set up a local WordPress environment (e.g., Local by Flywheel, XAMPP, Docker).

Check out the branch you want to work on:

git checkout develop

git checkout -b <branch name>

## Make changes, commit, and push:
git add .
git commit -m "Brief description of changes"
git push origin feature/your-feature

Maak een pull request om naar Develop of Main te pushen, voeg er tenminste 1 andere developer aan om het te reviewen.

## Project setup
git clone in de theme folder van een WordPress project
navigeer naar de folder
npm install

## Local Development
npm run dev
