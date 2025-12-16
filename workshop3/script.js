const API_URL = 'http://localhost:3000/movies';

const movieListDiv = document.getElementById('movie-list');
const searchInput = document.getElementById('search-input');
const form = document.getElementById('add-movie-form');
const statusDiv = document.getElementById('status');
const toast = document.getElementById('toast');

const editDialog = document.getElementById('edit-dialog');
const editForm = document.getElementById('edit-form');
const editIdInput = document.getElementById('edit-id');
const editTitleInput = document.getElementById('edit-title');
const editGenreInput = document.getElementById('edit-genre');
const editYearInput = document.getElementById('edit-year');
const cancelEditBtn = document.getElementById('cancel-edit');

let allMovies = []; 
let currentFetchAbortController = null; 
function showStatus(text) {
  statusDiv.textContent = text;
}

function showToast(message, type = 'info') {
  toast.textContent = message;
  toast.className = `toast ${type}`;
  toast.hidden = false;
  setTimeout(() => { toast.hidden = true; }, 3500);
}

function debounce(fn, delay = 300) {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => fn(...args), delay);
  };
}

function renderMovies(moviesToDisplay) {
  movieListDiv.innerHTML = '';

  if (!moviesToDisplay || moviesToDisplay.length === 0) {
    movieListDiv.innerHTML = '<p class="muted">No movies found matching your criteria.</p>';
    return;
  }

  const fragment = document.createDocumentFragment();

  moviesToDisplay.forEach(movie => {
    const item = document.createElement('article');
    item.className = 'movie-item';
    item.dataset.id = movie.id;

    const title = document.createElement('h3');
    title.textContent = `${movie.title} (${movie.year})`;

    const details = document.createElement('p');
    details.className = 'muted';
    details.textContent = movie.genre ? movie.genre : 'Genre: —';

    const actions = document.createElement('div');
    actions.className = 'actions';

    const editBtn = document.createElement('button');
    editBtn.className = 'btn edit';
    editBtn.textContent = 'Edit';
    editBtn.addEventListener('click', () => openEditDialog(movie));

    const deleteBtn = document.createElement('button');
    deleteBtn.className = 'btn del';
    deleteBtn.textContent = 'Delete';
    deleteBtn.addEventListener('click', () => deleteMovie(movie.id, movie.title));

    actions.appendChild(editBtn);
    actions.appendChild(deleteBtn);

    item.appendChild(title);
    item.appendChild(details);
    item.appendChild(actions);

    fragment.appendChild(item);
  });

  movieListDiv.appendChild(fragment);
}

/* ---------- CRUD operations ---------- */
async function fetchMovies() {
  showStatus('Loading movies...');
  try {
    const res = await fetch(API_URL);
    if (!res.ok) throw new Error('Failed to fetch movies from server');
    const movies = await res.json();
    allMovies = movies;
    renderMovies(allMovies);
    showStatus(`Showing ${movies.length} movie(s)`);
  } catch (err) {
    console.error(err);
    showStatus('Error loading movies. See console for details.');
    showToast('Cannot load movies. Is JSON Server running?', 'error');
  }
}

// Add new movie
form.addEventListener('submit', async (e) => {
  e.preventDefault();
  const title = form.title.value.trim();
  const genre = form.genre.value.trim();
  const yearVal = form.year.value.trim();

  if (!title || !yearVal) {
    showToast('Please provide both Title and Year.', 'warning');
    return;
  }

  const year = parseInt(yearVal, 10);
  if (isNaN(year) || year < 1888 || year > new Date().getFullYear() + 5) {
    showToast('Enter a valid year.', 'warning');
    return;
  }

  const newMovie = { title, genre, year };

  try {
    const res = await fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(newMovie),
    });

    const resText = await res.text();

    if (!res.ok) {
      let details = '';
      try {
        const parsed = JSON.parse(resText);
        details = parsed.message || JSON.stringify(parsed);
      } catch (e) {
        details = resText;
      }
      throw new Error(`Server responded ${res.status} ${res.statusText}${details ? ` — ${details}` : ''}`);
    }

    const created = resText ? JSON.parse(resText) : null;
    showToast(`Added: ${created && created.title ? created.title : 'movie'}`, 'success');
    form.reset();
    await fetchMovies();
  } catch (err) {
    console.error('Add movie error details:', err);
    showToast(`Error adding movie: ${err.message}`, 'error');
    showStatus('Failed to add movie. Check console/network and ensure json-server is running.');
  }
});

async function deleteMovie(movieId, title = '') {
  const ok = confirm(`Delete "${title}"? This cannot be undone.`);
  if (!ok) return;

  try {
    const res = await fetch(`${API_URL}/${movieId}`, { method: 'DELETE' });
    if (!res.ok) throw new Error('Failed to delete movie');
    showToast('Movie deleted', 'success');
    await fetchMovies();
  } catch (err) {
    console.error(err);
    showToast('Error deleting movie', 'error');
  }
}

function openEditDialog(movie) {
  editIdInput.value = movie.id;
  editTitleInput.value = movie.title;
  editGenreInput.value = movie.genre || '';
  editYearInput.value = movie.year;

  if (typeof editDialog.showModal === 'function') {
    editDialog.showModal();
    editTitleInput.focus();
  } else {
    const title = prompt('Title:', movie.title);
    if (title === null) return; 
    const year = prompt('Year:', movie.year);
    if (year === null) return;
    const genre = prompt('Genre:', movie.genre || '');
    if (genre === null) return;
    updateMovie(movie.id, { id: movie.id, title, year: parseInt(year, 10), genre });
  }
}

editForm.addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = editIdInput.value;
  const title = editTitleInput.value.trim();
  const genre = editGenreInput.value.trim();
  const year = parseInt(editYearInput.value, 10);

  if (!title || isNaN(year)) {
    showToast('Please provide title and valid year.', 'warning');
    return;
  }

  await updateMovie(id, { id: parseInt(id, 10), title, genre, year });
  editDialog.close();
});

cancelEditBtn.addEventListener('click', () => {
  if (typeof editDialog.close === 'function') editDialog.close();
});

async function updateMovie(movieId, updatedMovieData) {
  try {
    const res = await fetch(`${API_URL}/${movieId}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(updatedMovieData),
    });
    if (!res.ok) throw new Error('Failed to update movie');
    const updated = await res.json();
    showToast(`Updated: ${updated.title}`, 'success');
    await fetchMovies();
  } catch (err) {
    console.error(err);
    showToast('Error updating movie', 'error');
  }
}

function applySearch(term) {
  const q = term.trim().toLowerCase();
  if (!q) {
    renderMovies(allMovies);
    showStatus(`Showing ${allMovies.length} movie(s)`);
    return;
  }

  const filtered = allMovies.filter(movie => {
    const titleMatch = movie.title.toLowerCase().includes(q);
    const genreMatch = (movie.genre || '').toLowerCase().includes(q);
    return titleMatch || genreMatch;
  });

  renderMovies(filtered);
  showStatus(`Showing ${filtered.length} result(s) for "${term}"`);
}

const debouncedSearch = debounce((e) => applySearch(e.target.value), 300);
searchInput.addEventListener('input', debouncedSearch);


fetchMovies();

window.addEventListener('keydown', (e) => {
  if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
    e.preventDefault();
    searchInput.focus();
  }
});
