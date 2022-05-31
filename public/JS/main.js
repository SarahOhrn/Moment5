"use strict"

//Variables
let courseEl = document.getElementById('courses');
let nameEl = document.getElementById('name');
let codeEl = document.getElementById('code');
let progressionEl = document.getElementById('progression');
let coursesplanEl = document.getElementById('courseplan');
let addCourseEl = document.getElementById('addCourse');


//Eventlistener
window.addEventListener('load', getCourses);
addCourseEl.addEventListener('click', addCourse);


//Functions
function getCourses() {
    courseEl.innerHTML = '';

    fetch('http://localhost:8080/Moment5/rest.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(courses => {
                courseEl.innerHTML +=
                    `<div class=courses>
                    <p>
                    <b>Kurskod:</b>${courses.code}<br>
                    <b>Kursnamn:</b>${courses.name}<br>
                    <b>Progression:</b>${courses.progression}<br>
                    <b>Kursplan:</b>${courses.coursesyllabus}
                    </p>
                    <button id = ${courses.id} onClick="deleteCourse(${courses.id})">Radera kurs</button>
                </div>`
            });
        })
}

function deleteCourse(id) {
    fetch('http://localhost:8080/Moment5/rest.php?id=' + id, {
            method: 'DELETE',
        })
        .then(response => response.json())
        .then(data => {
            getCourses();
        })
        .catch(error => {
            console.log('Error:', error)
        })
}

function addCourse() {
    let name = nameInput.value;
    let code = codeInput.value;
    let progression = progressionInput.value;
    let courseplan = courseplanInput.value;

    let course = { "name": name, "code": code, "progression": progression, "courseplan": courseplan };

    fetch('http://localhost:8080/Moment5/rest.php', {
            method: 'POST',
            body: JSON.stringify(course),
        })
        .then(response => response.json())
        .then(data => {
            getCourses();
        })
        .catch(error => {
            console.log('Error:', error)
        })

}