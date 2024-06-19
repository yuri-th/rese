import Vue from 'vue';
import StarRating from 'vue-star-rating';

Vue.component('star-rating', StarRating.default || StarRating);

document.addEventListener('DOMContentLoaded', function () {
    const ratingApp = document.getElementById('ratingApp');
    if (ratingApp) {
        new Vue({
            el: '#ratingApp',
            data: {
                rating: 0
            },
            methods: {
                setRating(rating) {
                    this.rating = rating;
                }
            }
        });
    }

    document.querySelectorAll('.user-post').forEach((el, index) => {
        const starsEl = el.querySelector('.star-rating');
        if (starsEl) {
            new Vue({
                el: starsEl,
                data: {
                    selectedRating: parseFloat(starsEl.getAttribute('data-review-stars'))
                },
                methods: {
                    updateRating(rating) {
                        this.selectedRating = rating;
                    }
                }
            });
        }
    });

    document.querySelectorAll('.other-user-post .star-rating').forEach((el, index) => {
        new Vue({
            el: el,
            data: {
                selectedRating: parseFloat(el.getAttribute('data-review-stars'))
            }
        });
    });
});