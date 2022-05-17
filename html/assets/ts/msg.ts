export const showMessage = (elem: string): void => {
  const time: number = 4000;
  const $msgElm = document.querySelector(elem);

  if ($msgElm !== null) {
    $msgElm.classList.add('active');
    setTimeout(() => {
      $msgElm.classList.remove('active');
    }, time);
  }
};
