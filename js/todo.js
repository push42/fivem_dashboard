// JavaScript code for the to-do list
const taskInput = document.getElementById('task-input');
const addTaskButton = document.getElementById('add-task-button');
const taskList = document.getElementById('task-list');

addTaskButton.addEventListener('click', function () {
  const taskText = taskInput.value.trim();
  if (taskText !== '') {
    const li = document.createElement('li');
    li.textContent = taskText;
    taskList.appendChild(li);
    taskInput.value = '';
  }
});

taskInput.addEventListener('keydown', function (event) {
  if (event.keyCode === 13) {
    addTaskButton.click();
  }
});

taskList.addEventListener('click', function (event) {
  if (event.target.tagName === 'LI') {
    event.target.remove();
  }
});

