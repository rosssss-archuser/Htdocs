# RESTful Movie List — Workshop

This small app demonstrates client-side CRUD operations using the Fetch API and a simulated backend (json-server).

## Files
- `movies.json` — seed database for json-server (resource: `/movies`).
- `index.html` — main frontend UI.
- `script.js` — application logic (GET/POST/PUT/DELETE) with debounced search and improved UX.
- `styles.css` — styling and small accessibility improvements.

## Requirements
- Node.js and npm (for json-server).
- Optional: VS Code Live Server extension (recommended) or Python's `http.server` for serving `index.html`.

## Setup
1. Install JSON Server globally (one time):

   npm install -g json-server

2. Start the JSON Server in the project directory:

   json-server --watch movies.json

   By default it runs at `http://localhost:3000`. The resource URL is `http://localhost:3000/movies`.

3. Serve the frontend pages (recommended):
- Option A — Live Server extension (VS Code): Right-click `index.html` -> "Open with Live Server".
- Option B — Python simple server (in project directory):

  python -m http.server 5500

  Then open `http://localhost:5500/index.html` in your browser.

Note: Some browsers restrict `file://` pages from using `fetch()` to `http://` endpoints. If something doesn't work, use Live Server or Python's server above.

## Using the App
- Add a movie using the form. Title and year are required.
- Use the search box to filter by title or genre (search is debounced for better UX).
- Edit a movie using the *Edit* button (opens an edit dialog); save to send an update.
- Delete a movie using the *Delete* button (confirmation required).
- Shortcuts: `Ctrl/Cmd + K` focuses the search input.

## Testing Checklist
- [ ] Run `json-server --watch movies.json` and confirm `GET /movies` returns the seed data.
- [ ] Open `index.html` via a server and see the list of movies.
- [ ] Add a new movie → appears in the list and persists in `movies.json`.
- [ ] Edit a movie → updated on the page and in `movies.json`.
- [ ] Delete a movie → removed from page and `movies.json`.
- [ ] Use search to filter results.

## Troubleshooting
- If movies do not load: Ensure json-server is running and accessible at `http://localhost:3000`.
- If fetch is blocked: Serve the frontend over `http://` (Live Server / http.server recommended).

---

If you'd like, I can also add automated tests or a small npm `package.json` with a `start` script that launches `json-server` and a static server simultaneously. Want me to add that?