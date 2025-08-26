// core version + navigation, pagination modules:
import Swiper from 'swiper';
import { EffectFade, Navigation, Pagination } from 'swiper/modules';

// init Swiper:
export const swiper = new Swiper('.hero', {
  effect: 'fade',
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  modules: [EffectFade, Navigation, Pagination],
});
