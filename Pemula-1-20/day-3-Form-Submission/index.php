<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nojin Notes</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background-color: #f3f4f6;
      display: flex;
      justify-content: center;
      align-items: flex-start; /* Changed to flex-start to keep the header fixed */
      min-height: 100vh;
    }
    .container {
      margin-top: 2rem; /* Adjusted margin to create space below the header */
      max-width: 600px; /* Adjusted width for desktop view */
    }
    .card {
      transition: transform 0.2s ease-in-out;
      padding: 1.5rem; /* Reduced padding for a more compact card */
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Tambah efek bayangan pada hover */
    }
    .btn-circle {
      background-color: #3b82f6; /* Primary color for the floating button */
    }
    .btn-circle:hover {
      background-color: #2563eb; /* Slightly darker on hover */
    }
    .note-content {
      overflow-wrap: break-word; /* Prevent long text from overflowing */
      max-width: 100%; /* Ensure it doesn't exceed the card width */
    }
  </style>
</head>
<body>

  <div class="container mx-auto p-4">
    <h1 class="text-4xl font-bold mb-6 text-center text-blue-600">Nojin Notes</h1>

    <!-- Display notes -->
    <div class="space-y-4" id="notes-container">
      <?php
      $notes = json_decode(file_get_contents('notes.json'), true) ?? [];

      if (empty($notes)) {
        echo "
          <div class='alert alert-info shadow-lg'>
            <div>
              <i class='fas fa-info-circle'></i>
              <span>No notes yet! Click the + button to add your first note.</span>
            </div>
          </div>
        ";
      } else {
        foreach (array_slice($notes, 0, 5) as $id => $note) { // Display first 5 notes
          echo "
          <div class='card w-full bg-white shadow-lg rounded-lg'>
            <div class='flex flex-col'>
              <div>
                <h2 class='text-xl font-semibold text-gray-800'>{$note['title']}</h2>
                <p class='text-gray-600 note-content'>{$note['content']}</p>
                <p class='text-xs text-gray-400'>Created on: " . date('Y-m-d H:i:s', strtotime($note['date']) + 7 * 3600) . "</p>
              </div>
              <form method='POST' action='delete_note.php' class='mt-2'>
                <input type='hidden' name='note_id' value='{$id}'>
                <button type='submit' class='btn btn-error btn-sm'><i class='fas fa-trash-alt'></i></button>
              </form>
            </div>
          </div>";
        }
      }
      ?>
    </div>

    <?php if (count($notes) > 5): ?>
      <div class="text-center mt-4">
        <button id="load-more" class="btn btn-outline btn-primary">Load More</button>
      </div>
    <?php endif; ?>

    <!-- Floating Add Note Button -->
    <div class="fixed bottom-6 right-6">
      <label for="addNoteModal" class="btn btn-primary btn-circle text-2xl shadow-lg">
        <i class="fas fa-plus"></i>
      </label>
    </div>
  </div>

  <!-- Add Note Modal -->
  <input type="checkbox" id="addNoteModal" class="modal-toggle" />
  <div class="modal">
    <div class="modal-box bg-white"> 
      <h3 class="font-bold text-lg text-gray-800">Add New Note</h3> 
      <form method="POST" action="add_note.php" class="mt-4 space-y-4">
        <div>
          <label class="label">
            <span class="label-text text-gray-800">Note Title</span>
          </label>
          <input type="text" name="title" class="input input-bordered w-full bg-white text-gray-800" required /> 
        </div>
        <div>
          <label class="label">
            <span class="label-text text-gray-800">Note Content</span> 
          </label>
          <textarea name="content" class="textarea textarea-bordered w-full bg-white text-gray-800" required></textarea> 
        </div>
        <div class="modal-action">
            <label for="addNoteModal" class="btn border-white bg-white text-gray-800 hover:bg-gray-200">Close</label>
          <button type="submit" class="btn btn-primary bg-blue-500 text-white hover:bg-blue-600">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- JavaScript to load more notes -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let loadMoreButton = document.getElementById('load-more');
      let notesContainer = document.getElementById('notes-container');
      let notes = <?php echo json_encode($notes); ?>;
      let notesLoaded = 5;

      if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function() {
          let nextNotes = notes.slice(notesLoaded, notesLoaded + 5);
          nextNotes.forEach((note, id) => {
            let noteHTML = `
              <div class='card w-full bg-white shadow-lg rounded-lg p-4'>
                <div class='flex flex-col'>
                  <div>
                    <h2 class='text-xl font-semibold text-gray-800'>${note.title}</h2>
                    <p class='text-gray-600 note-content'>${note.content}</p>
                    <p class='text-xs text-gray-400'>Created on: ${new Date(note.date).toLocaleString('en-US', { timeZone: 'Asia/Jakarta' })}</p>
                  </div>
                  <form method='POST' action='delete_note.php' class='mt-2'>
                    <input type='hidden' name='note_id' value='${id}'>
                    <button type='submit' class='btn btn-error btn-sm'><i class='fas fa-trash-alt'></i></button>
                  </form>
                </div>
              </div>
            `;
            notesContainer.insertAdjacentHTML('beforeend', noteHTML);
          });
          notesLoaded += 5;

          if (notesLoaded >= notes.length) {
            loadMoreButton.style.display = 'none'; // Hide button when no more notes to load
          }
        });
      }
    });
  </script>
</body>
</html>
