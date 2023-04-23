// Assignment 2 reuses Lab 6 script.php script [1]. 
function uploadFile() {
    var form = new FormData();
    form.append('file', document.querySelector('#imageFile').files[0]);
    form.append('upload', true);

    // Found solution at [2]
    var element = document.getElementById('imageFile');
    var imageName = element.files[0].name;

    var upload = new XMLHttpRequest();
    upload.open('POST', 'upload.php');
    upload.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText == 1) {
                document.querySelector('#uploadError').innerText = "Image uploaded successfully.";
                // Found solution at [3]
                document.getElementById('imageName').value = imageName;
            } else {
                document.querySelector('#uploadError').innerText = "An error occurred when uploading the image";
            }
        }
    };
    upload.send(form);
}
// References cited:
// [1] C. Lee-Hone, CST8285 - Lab 6 - script.js. Algonquin College, 2022.
// [2] user: maxime schoeni, "Javascript - How to extract filename from a file input control - Stack Overflow," Stack Overflow, Nov. 05, 2016. https://stackoverflow.com/questions/857618/javascript-how-to-extract-filename-from-a-file-input-control (accessed Apr. 08, 2022).
// [3] user: leong shing chew, "Change a value of an input (Example) | Treehouse Community," Treehouse, Jun. 16, 2015. https://teamtreehouse.com/community/change-a-value-of-an-input (accessed Apr. 08, 2022).