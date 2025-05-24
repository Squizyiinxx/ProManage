<!-- Footer.vue -->
<template>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <div class="footer-logo">
                    <img src="/assets/logoPro.png" :alt="companyName" class="logo-img" />
                    <h3>{{ companyName }}</h3>
                </div>
                <p class="footer-description">{{ companyDescription }}</p>
                <div class="social-links">
                    <a v-for="social in socialMedia" :key="social.name" :href="social.url" :aria-label="social.name" class="social-icon">
                        <component :is="social.icon" />
                    </a>
                </div>
            </div>

            <div class="footer-links-container">
                <div v-for="(section, index) in linkSections" :key="index" class="footer-section">
                    <h4 class="footer-heading">{{ section.title }}</h4>
                    <ul class="footer-links">
                        <li v-for="link in section.links" :key="link.name">
                            <a :href="link.url">{{ link.name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">&copy; {{ new Date().getFullYear() }} {{ companyName }}. {{ copyrightText }}</p>
            <div class="language-selector" v-if="languages.length > 0">
                <select v-model="selectedLanguage" @change="changeLanguage">
                    <option v-for="lang in languages" :key="lang.code" :value="lang.code">{{ lang.name }}</option>
                </select>
            </div>
        </div>
    </footer>
</template>

<script lang="ts">
import { defineComponent, PropType, ref } from 'vue';

interface SocialMedia {
    name: string;
    url: string;
    icon: any;
}

interface FooterLink {
    name: string;
    url: string;
}

interface LinkSection {
    title: string;
    links: FooterLink[];
}

interface Language {
    code: string;
    name: string;
}

export default defineComponent({
    name: 'AppFooter',

    props: {
        companyName: {
            type: String,
            default: 'ProManage',
        },
        companyDescription: {
            type: String,
            default: 'lorem ipsu dolor sit amet dadadh...',
        },
        socialMedia: {
            type: Array as PropType<SocialMedia[]>,
            default: () => [],
        },
        linkSections: {
            type: Array as PropType<LinkSection[]>,
            default: () => [],
        },
        copyrightText: {
            type: String,
            default: 'Semua hak cipta dilindungi.',
        },
        languages: {
            type: Array as PropType<Language[]>,
            default: () => [],
        },
        defaultLanguage: {
            type: String,
            default: 'id',
        },
    },

    setup(props, { emit }) {
        const selectedLanguage = ref(props.defaultLanguage);

        const changeLanguage = (event: Event) => {
            const target = event.target as HTMLSelectElement;
            emit('language-change', target.value);
        };

        return {
            selectedLanguage,
            changeLanguage,
        };
    },
});
</script>

<style scoped>
.footer {
    background-color: #1a1a1a;
    color: #f5f5f5;
    padding: 3rem 0 1.5rem;
    font-family: 'Inter', sans-serif;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.footer-section {
    flex: 1;
    min-width: 250px;
    margin-bottom: 2rem;
}

.footer-logo {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.logo-img {
    width: 40px;
    height: 40px;
    margin-right: 0.75rem;
}

.footer-description {
    color: #b3b3b3;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #333;
    color: #fff;
    transition: background-color 0.3s ease;
}

.social-icon:hover {
    background-color: #4a6cf7;
}

.footer-links-container {
    display: flex;
    flex-wrap: wrap;
    flex: 2;
}

.footer-heading {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1.25rem;
    color: #fff;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-links a {
    color: #b3b3b3;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #4a6cf7;
}

.footer-bottom {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #333;
}

.copyright {
    color: #b3b3b3;
    font-size: 0.9rem;
}

.language-selector select {
    background-color: #333;
    color: #fff;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
    }

    .footer-section {
        width: 100%;
        margin-bottom: 2rem;
    }

    .footer-links-container {
        width: 100%;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}
</style>
