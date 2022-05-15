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
function initImagePreview() {
  const imagePreview = document.getElementById('imagePreview');
  const formImage = document.getElementById('form__image');
  const formImagePreview = document.getElementById('form__imagePreview');
  const deleteBtn = document.getElementById('deleteImage');
  const hiddenImage = document.getElementById('hiddenImage');

  deleteBtn.addEventListener('click', function () {
    imagePreview.src = '';
    formImagePreview.style.display = 'none';
    formImage.style.display = 'block';
    imagePreview.classList.remove('active');
    hiddenImage.value = '';
  });

  if (isImage(imagePreview.src) || (isBase64Image(imagePreview.src) && imagePreview.classList.contains('active'))) {
    formImagePreview.style.display = 'block';
    formImage.style.display = 'none';
  } else {
    formImagePreview.style.display = 'none';
    formImage.style.display = 'block';
  }
}

function previewImage(elm) {
  const imagePreview = document.getElementById('imagePreview');
  let fileReader = new FileReader();

  fileReader.onload = function () {
    imagePreview.src = fileReader.result;
  };
  fileReader.readAsDataURL(elm.files[0]);

  imagePreview.classList.add('active');
  initImagePreview();
}

if (document.getElementById('form--post') !== null) {
  initImagePreview();

  document.getElementById('uploadImage').addEventListener('change', function () {
    previewImage(this);
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
