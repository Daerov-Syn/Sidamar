export default function serviceDetail() {
    return {
        storageKey: '',
        checkedDocs: [],
        totalDocs: 0,
        faqSearch: '',
        faqs: [],
        init() {
            this.storageKey = this.$el.dataset.storageKey;
            this.totalDocs = Number(this.$el.dataset.documentCount);
            this.faqs = JSON.parse(this.$el.dataset.faqs);

            try {
                const saved = JSON.parse(localStorage.getItem(this.storageKey));
                if (Array.isArray(saved)) {
                    this.checkedDocs = saved.filter((index) => typeof index === 'number' && index >= 0 && index < this.totalDocs);
                }
            } catch {
                this.checkedDocs = [];
            }
        },
        get readyCount() {
            return this.checkedDocs.length;
        },
        get progressPercent() {
            return this.totalDocs > 0 ? Math.round(this.readyCount / this.totalDocs * 100) : 0;
        },
        get isAllReady() {
            return this.totalDocs > 0 && this.readyCount === this.totalDocs;
        },
        toggleDoc(index) {
            if (this.checkedDocs.includes(index)) {
                this.checkedDocs = this.checkedDocs.filter((checkedIndex) => checkedIndex !== index);
            } else {
                this.checkedDocs.push(index);
            }
            this.saveDocuments();
        },
        markAll() {
            this.checkedDocs = this.isAllReady ? [] : Array.from({ length: this.totalDocs }, (_, index) => index);
            this.saveDocuments();
        },
        saveDocuments() {
            try {
                localStorage.setItem(this.storageKey, JSON.stringify(this.checkedDocs));
            } catch {
                // The checklist remains usable when browser storage is unavailable.
            }
        },
        filteredFaqs() {
            const query = this.faqSearch.trim().toLowerCase();
            return this.faqs.filter((faq) => faq.q.toLowerCase().includes(query) || faq.a.toLowerCase().includes(query));
        },
    };
}
