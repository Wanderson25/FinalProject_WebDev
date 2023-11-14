const commentInput = document.querySelector('#comment-input');
function update_height() {
    commentInput.style.overflowY = 'hidden';
    commentInput.style.height = 'auto';
    commentInput.style.height = commentInput.scrollHeight + 'px';
}
commentInput.addEventListener('input', update_height);

function generateComment(name, content, date) {
    return `<div class="s_cm">
                ${name}
                <ul class="cm_cm">
                    <li class="cm_it">${content}</li>
                    <li class="cm_dt">${date}</li>
                </ul>
            </div>`;
}

document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();
    let comment = commentInput.value;
    let data = new FormData();
    data.append('comment_text', comment);
    data.append('user_id', user_id);
    data.append('song_id', song_id);
    fetch('submit_comment.php', {
        method: 'POST',
        body: data
    }).then(response => response.text())
      .then(data => {
          // update page content with response from PHP script
          let name = user_name; // replace with actual user name
          let date = new Date().toISOString().slice(0, 10);
          let newComment = generateComment(name, comment, date);
          document.querySelector('.real_cm').insertAdjacentHTML('afterbegin', newComment);
          special_message.innerHTML = "Comment added!";
      });
});