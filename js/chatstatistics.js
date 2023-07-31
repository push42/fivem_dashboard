function updateMostPresentUsername() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_most_present_username.php', true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        const mostPresentUsername = xhr.responseText;
        const contentElement = document.querySelector('.new-section-2');
  
        const crownImage = document.createElement('img');
        crownImage.src = 'img/crown.gif';
        crownImage.alt = 'Crown';
        crownImage.classList.add('crown');
  
        const usernameText = document.createTextNode(mostPresentUsername);
  
        contentElement.innerHTML = '';
        contentElement.appendChild(crownImage);
        contentElement.appendChild(usernameText);
      } else {
        console.error('Error fetching most present username:', xhr.status);
      }
    };
    xhr.onerror = function () {
      console.error('Error sending AJAX request to get_most_present_username.php');
    };
    xhr.send();
  }
  
  updateMostPresentUsername();
  
  
setInterval(updateMostPresentUsername, 5000);