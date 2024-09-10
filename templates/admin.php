<div id="skeleton-management">
    <h2>Skeleton Folder Management</h2>
    <div id="skeleton-contents"></div>

    <h3>Upload a File</h3>
    <form id="upload-form">
        <input type="file" id="file-to-upload" />
        <button type="submit">Upload</button>
    </form>

    <h3>Logs</h3>
    <div id="log-box"></div>
</div>

<script>
  function logMessage(message) {
      const logBox = document.getElementById('log-box');
      logBox.innerHTML += `<p>${message}</p>`;
  }

  document.addEventListener('DOMContentLoaded', function() {
      fetch(OC.generateUrl('/apps/skeleton_management/getSkeletonContents'))
          .then(response => response.json())
          .then(data => {
              const contentsEl = document.getElementById('skeleton-contents');
              contentsEl.innerHTML = data.contents.map(file => `
                  <p>${file} <button onclick="deleteFile('${file}')">Delete</button></p>
              `).join('');
          });

      document.getElementById('upload-form').addEventListener('submit', function(e) {
          e.preventDefault();
          const fileInput = document.getElementById('file-to-upload');
          const formData = new FormData();
          formData.append('file', fileInput.files[0]);

          fetch(OC.generateUrl('/apps/skeleton_management/uploadSkeletonFile'), {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  logMessage('File uploaded successfully');
              } else {
                  logMessage('Error: ' + data.error);
              }
          });
      });
  });

  function deleteFile(filename) {
      fetch(OC.generateUrl('/apps/skeleton_management/deleteSkeletonFile'), {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ filename: filename })
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              logMessage('File deleted successfully');
              location.reload(); // Refresh the contents list
          } else {
              logMessage('Error: ' + data.error);
          }
      });
  }
</script>
