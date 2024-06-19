import Vue from 'vue';
import StarRating from 'vue-star-rating';

Vue.component('star-rating', StarRating.default || StarRating);

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOMContentLoaded');
    document.querySelectorAll('.star-rating').forEach(function (el, index) {
        console.log('Element:', el, 'Index:', index);
        el.setAttribute('id', `averageStars${index}`);
        new Vue({
            el: `#averageStars${index}`,
            data() {
                return {
                    rating: parseFloat(el.getAttribute('data-rating')),
                    isStarsChanged: false
                };
            },
            methods: {
                updateRating(rating) {
                    this.rating = rating;
                    this.isStarsChanged = true;
                }
            }
        });
    });
});