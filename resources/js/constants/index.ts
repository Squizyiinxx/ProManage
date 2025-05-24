import { Bell, ClipboardList, FileClock, MonitorSmartphone, Timer, Users2 } from 'lucide-vue-next';

export const statusTask = [
    { id: 'pending', name: 'Pending' },
    { id: 'in_progress', name: 'In Progress' },
    { id: 'completed', name: 'Completed' },
];

export const presets = [
    { key: '', label: 'All' },
    { key: 'today', label: 'Today' },
    { key: 'month', label: 'This Month' },
    { key: 'year', label: 'This Year' },
];

export const roleOptions = [
    { id: 'Administrator', name: 'Administrator' },
    { id: 'Manager', name: 'Manager' },
    { id: 'Member', name: 'Member' },
];

export const is_activeOptions = [
    { id: 1, name: 'Active' },
    { id: 0, name: 'InActive' },
];

export const priority = [
    { id: 'low', name: 'Low' },
    { id: 'medium', name: 'Medium' },
    { id: 'high', name: 'High' },
];

export const columnProject = Object.entries({
    name: 'Project Name',
    description: 'Description',
    client_id: 'Client',
    manager_id: 'Manager',
    status: 'Status',
    started_at: 'Start Date',
    deadline: 'Deadline',
    created_at: 'Created At',
    updated_at: 'Updated At',
});
export const columnTask = Object.entries({
    title: 'Title',
    description: 'Description',
    created_by: 'Created By',
    project_id: 'Project',
    assigned_to: 'Assigned To',
    status: 'Status',
    priority: 'Priority',
    due_date: 'Due Date',
    created_at: 'Created At',
    updated_at: 'Updated At',
});
export const columnUser = Object.entries({
    name: 'Name',
    email: 'Email',
    password: 'Password',
    is_active: 'Active',
    created_at: 'Created At',
    updated_at: 'Updated At',
});
export const columnClient = Object.entries({
    name: 'Client Name',
    email: 'Email',
    phone: 'Phone',
    company: 'Company',
    address: 'Address',
    is_active: 'Active',
    created_at: 'Created At',
    updated_at: 'Updated At',
});

export const features = [
    {
        title: ' Manajemen Proyek & Tugas Sederhanakan',
        description:
            'Kelola proyek dan tugas dengan mudah. Lacak kemajuan, setel batas waktu, dan prioritaskan pekerjaan untuk memastikan tim Anda tetap dalam jalur.',
        icon: ClipboardList,
        delay: 0,
    },
    {
        title: 'Pelacakan Waktu yang Mudah',
        description: 'Pelacakan waktu kerja Anda dengan mudah, setel interval waktu, dan pantau waktu yang dihabiskan untuk setiap proyek.',
        icon: Timer,
        delay: 100,
    },
    {
        title: 'Manajemen Peran & Izin',
        description: 'Sistem kontrol akses yang fleksibel. Definisikan peran dan izin berdasarkan struktur tim dan kebutuhan keamanan.',
        icon: Users2,
        delay: 200,
    },
    {
        title: 'Notifikasi Real-time',
        description: 'Pembaruan instan pada aktivitas proyek, tugas baru, dan komentar. Jangan pernah melewatkan pembaruan penting lagi.',
        icon: Bell,
        delay: 300,
    },
    {
        title: 'Antarmuka yang Interaktif',
        description: 'Antarmuka modern dan intuitif yang dibangun dengan Vue + Inertia. Pengalaman pengguna yang halus dan responsif.',
        icon: MonitorSmartphone,
        delay: 400,
    },
    {
        title: 'Sistem Audit Trail',
        description: 'Lacak setiap perubahan secara detail. Ketahui siapa yang mengubah apa dan kapan untuk akuntabilitas penuh.',
        icon: FileClock,
        delay: 500,
    },
];

export const pricingPlans = {
    starter: {
        name: 'Starter',
        description: 'Untuk tim kecil yang baru memulai',
        price: 'Rp 149k',
        interval: '/bulan',
        features: [
            { text: 'Hingga 5 pengguna', included: true },
            { text: 'Manajemen proyek dasar', included: true },
            { text: 'Import/Export Excel', included: true },
            { text: 'Email support', included: true },
            { text: 'Role & permission lanjutan', included: false },
            { text: 'Sistem audit & histori', included: false },
        ],
        ctaLink: '/register?plan=starter',
        ctaText: 'Pilih Paket',
    },
    professional: {
        name: 'Professional',
        description: 'Untuk tim menengah dengan kebutuhan lebih kompleks',
        price: 'Rp 399k',
        interval: '/bulan',
        features: [
            { text: 'Hingga 25 pengguna', included: true },
            { text: 'Manajemen proyek penuh', included: true },
            { text: 'Import/Export Excel lanjutan', included: true },
            { text: 'Role & permission lanjutan', included: true },
            { text: 'Sistem audit & histori', included: true },
            { text: 'Prioritas support', included: true },
        ],
        ctaLink: '/register?plan=professional',
        ctaText: 'Pilih Paket',
        isPrimary: true,
    },
    enterprise: {
        name: 'Enterprise',
        description: 'Untuk perusahaan besar dengan kebutuhan khusus',
        price: 'Custom',
        interval: '',
        features: [
            { text: 'Pengguna tidak terbatas', included: true },
            { text: 'Semua fitur Professional', included: true },
            { text: 'Integrasi API kustom', included: true },
            { text: 'Pelatihan dan onboarding', included: true },
            { text: 'SLA guarantee', included: true },
            { text: 'Dedicated account manager', included: true },
        ],
        ctaLink: '/contact-sales',
        ctaText: 'Hubungi Sales',
    },
};
