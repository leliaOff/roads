<template>
    <div class="profile">
        <div>
            <div class="profile-image">
                <img :src="user.image" :alt="fullName" :title="fullName" />
            </div><!--
            --><div class="profile-data">
                <div class="profile-data-item">{{ user.lastname }}</div>
                <div class="profile-data-item">{{ user.firstname }}</div>
                <div class="profile-data-item">{{ user.middlename }}</div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        data() {
            return {
                user: {
                    firstname   : 'Алёна',
                    middlename  : 'Игоревна',
                    lastname    : 'Артамоненко',
                    image       : './images/woman.jpg'
                }
            }
        },

        computed: {
            
            fullName() {
                return `${this.user.lastname} ${this.user.firstname} ${this.user.middlename}`;
            }

        },

    }
</script>
