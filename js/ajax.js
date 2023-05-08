function fetchPosts() {
    $.ajax({
      url: 'fetch_posts.php',
      type: 'GET',
      success: function(response) {
        $('#clanky').html(response);
  
        // Reapply click event listener to "Open" buttons
        let openBtns = document.querySelectorAll('.open-btn');
        let modalTitle = document.querySelector('.modal-title');
  
        openBtns.forEach(btn => {
          btn.removeEventListener('click', openModal);
          btn.addEventListener('click', openModal);
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }
  
  function openModal() {
    let desc = this.dataset.desc;
    let title = this.closest('.card').querySelector('.card-title').textContent;
    let articleDescEl = document.querySelector('#articleDesc');
    articleDescEl.innerHTML = desc;
    modalTitle.innerHTML = title;
  }
  
  $(document).ready(function() {
    // Fetch posts on page load
    fetchPosts();
  
    // Fetch posts every 5 seconds
    setInterval(fetchPosts, 5000);
  
    // Add click event listener to "Open" buttons
    let openBtns = document.querySelectorAll('.open-btn');
    let modalTitle = document.querySelector('.modal-title');
  
    openBtns.forEach(btn => {
      btn.addEventListener('click', openModal);
    });
  });
  