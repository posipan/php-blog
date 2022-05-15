function showToastInfo() {
  const TIME = 4000;
  const toastElm = document.querySelector('.toast.toast--info');

  if (toastElm !== null) {
    toastElm.classList.add('active');
    setTimeout(function () {
      toastElm.classList.remove('active');
    }, TIME);
  }
}

showToastInfo();

const isImage = (fileName) => {
  fileName = fileName.substring(fileName.lastIndexOf('.'));
  if (fileName.match(/\.(jpg|jpeg|png|gif|svg)$/i)) {
    return true;
  }
  return false;
};

const isBase64Image = (fileName) => {
  if (fileName.match(/^(data:image)?/i)) {
    return true;
  }
  return false;
};

/**
 * Mypage Post
 */
function initPreview() {
  const preview = document.getElementById('preview');
  const formImage = document.getElementById('form__image');
  const formPreview = document.getElementById('form__preview');
  const deleteBtn = document.getElementById('delete-image');
  const hiddenImage = document.getElementById('hidden-image');

  deleteBtn.addEventListener('click', function () {
    preview.src = '';
    formPreview.style.display = 'none';
    formImage.style.display = 'block';
    preview.classList.remove('active');
    hiddenImage.value = '';
  });

  if (isImage(preview.src) || (isBase64Image(preview.src) && preview.classList.contains('active'))) {
    formPreview.style.display = 'block';
    formImage.style.display = 'none';
  } else {
    formPreview.style.display = 'none';
    formImage.style.display = 'block';
  }
}

function createPreview(elm) {
  const preview = document.getElementById('preview');
  let fileReader = new FileReader();

  fileReader.onload = function () {
    preview.src = fileReader.result;
  };
  fileReader.readAsDataURL(elm.files[0]);

  preview.classList.add('active');
  initPreview();
}

if (document.getElementById('form--post') !== null) {
  initPreview();

  document.getElementById('upload-image').addEventListener('change', function () {
    createPreview(this);
  });
}

/**
 * Hamburger Menu
 */
const $mypageName = document.getElementById('mypage__name');
const breakPoint = 749;
$mypageName.addEventListener('click', function (e) {
  e.preventDefault();
  if (window.innerWidth <= breakPoint) {
    this.nextElementSibling.classList.toggle('active');
  } else {
    return false;
  }
});
