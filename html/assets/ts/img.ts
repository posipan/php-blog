/**
 * Thumbnail Image
 */

export const setPreview = () => {
  const $preview = document.getElementById('preview') as HTMLImageElement;

  if (!$preview) {
    return;
  }

  const isImage = (fileName: string): boolean => {
    const image = fileName.substring(fileName.lastIndexOf('.'));
    if (image.match(/\.(jpg|jpeg|png|gif|svg)$/i)) {
      return true;
    }
    return false;
  };

  const isBase64Image = (fileName: string): boolean => {
    if (fileName.match(/^(data:image)?/i)) {
      return true;
    }
    return false;
  };

  const initPreview = (): void => {
    const $formImage = document.getElementById('form__image') as HTMLElement;
    const $formPreview = document.getElementById('form__preview') as HTMLElement;
    const $deleteBtn = document.getElementById('delete-image') as HTMLElement;
    const $hiddenImage = document.getElementById('hidden-image') as HTMLInputElement;

    $deleteBtn.addEventListener('click', function () {
      $preview.src = '';
      $formPreview.style.display = 'none';
      $formImage.style.display = 'block';
      $preview.classList.remove('active');
      $hiddenImage.value = '';
    });

    if (isImage($preview.src) || (isBase64Image($preview.src) && $preview.classList.contains('active'))) {
      $formPreview.style.display = 'block';
      $formImage.style.display = 'none';
    } else {
      $formPreview.style.display = 'none';
      $formImage.style.display = 'block';
    }
  };

  const createPreview = (elem: HTMLInputElement): void => {
    const fileReader = new FileReader();
    const file = (elem.files as FileList)[0];

    fileReader.onload = () => {
      $preview.src = fileReader.result as string;
    };

    fileReader.readAsDataURL(file);

    $preview.classList.add('active');
    initPreview();
  };

  if (document.querySelector('.form--post')) {
    initPreview();

    const uploadImage = document.getElementById('upload-image') as HTMLInputElement;
    uploadImage.addEventListener('change', function () {
      createPreview(this);
    });
  }
};
