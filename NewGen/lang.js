// =========================================================
// NewGen - Sistema de Internacionalización (i18n)
// Soporta alternancia fluida entre Español (es) e Inglés (en)
// =========================================================

const newgenAppTranslations = {
  es: {
    lang_btn: "🌐 ES",
    
    // Top Bar & Común
    back_to_dashboard: "Volver al panel",
    back_to_tickets: "Volver a tickets",
    back_to_inventory: "Volver al inventario",
    back_to_users: "Volver a usuarios",
    logout_title: "Cerrar sesión",
    theme_title: "Cambiar tema",
    lang_title: "Cambiar idioma",
    
    // Roles
    role_admin: "Admin",
    role_technician: "Técnico",
    role_requester: "Solicitante",
    role_user: "Usuario",

    // Dashboard - Bienvenida y Perfil
    welcome_prefix: "Bienvenido, ",
    welcome_desc: "Gestioná tus recursos de software desde un solo lugar.",
    
    // Dashboard - Tarjetas de Navegación
    nav_home: "Inicio",
    nav_inventory: "Inventario",
    nav_tickets: "Tickets",
    nav_helpdesk: "Mesa de ayuda",
    nav_reports: "Reportes",
    nav_users: "Usuario",

    // Dashboard - Métricas Principales
    stat_stock: "Productos en stock",
    stat_stock_low: "Stock bajo",
    stat_movements: "Movimientos del mes",
    stat_vs_month: "vs. mes anterior",

    // Dashboard - Gráfico
    chart_title: "Evolución del inventario",
    chart_in: "Entradas",
    chart_out: "Salidas",
    month_jan: "Ene",
    month_feb: "Feb",
    month_mar: "Mar",
    month_apr: "Abr",
    month_may: "May",
    month_jun: "Jun",
    month_jul: "Jul",
    month_aug: "Ago",
    month_sep: "Sep",
    month_oct: "Oct",
    month_nov: "Nov",
    month_dec: "Dic",

    // Dashboard - Movimientos Recientes
    movements_title: "Últimos movimientos",
    movements_view_all: "Ver todos",
    movements_in: "Entrada",
    movements_out: "Salida",
    movements_item_laptops: "Laptops Lenovo ThinkPad T14",
    movements_item_monitors: "Monitores Dell 24\"",
    movements_item_keyboards: "Teclados mecánicos Logitech",
    movements_item_mice: "Mouses inalámbricos HP",
    movements_sub_stock: "Reposición de stock TI",
    movements_sub_assign: "Asignación a desarrollo",
    movements_sub_damaged: "Baja por daño físico",
    movements_sub_welcome: "Kit de bienvenida",

    // Inventario
    inv_title: "Inventario de equipos",
    inv_add_btn: "Agregar nuevo equipo",
    inv_th_id: "ID",
    inv_th_name: "Nombre",
    inv_th_category: "Categoría",
    inv_th_brand: "Marca",
    inv_th_model: "Modelo",
    inv_th_status: "Estado",
    inv_th_user: "Usuario asignado",
    inv_th_actions: "Acciones",
    inv_action_edit: "Editar",
    inv_action_delete: "Eliminar",
    inv_unassigned: "Sin asignar",

    // Tickets
    tickets_title: "Gestión de tickets",
    tickets_add_btn: "Crear nuevo ticket",
    tickets_th_id: "ID",
    tickets_th_title: "Título",
    tickets_th_desc: "Descripción",
    tickets_th_date: "Fecha",
    tickets_th_status: "Estado",
    tickets_th_priority: "Prioridad",
    tickets_th_user: "Solicitante",
    tickets_th_tech: "Técnico asignado",
    tickets_unassigned_tech: "Sin asignar",

    // Mesa de Ayuda / Nuevo Ticket
    new_ticket_title: "Crear nuevo ticket",
    new_ticket_problem: "Título del problema:",
    new_ticket_problem_ph: "Ej: Falla al encender equipo o sin red",
    new_ticket_desc: "Descripción detallada:",
    new_ticket_desc_ph: "Detalle lo que ocurre y el equipo afectado...",
    new_ticket_priority: "Prioridad:",
    prio_low: "Baja",
    prio_medium: "Media",
    prio_high: "Alta",
    new_ticket_user: "Usuario solicitante:",
    new_ticket_tech: "Técnico asignado:",
    new_ticket_submit: "Crear ticket",

    // Reportes
    reports_title: "Reportes del sistema",
    reports_print_btn: "Imprimir reporte",
    reports_card1_title: "Total de equipos por categoría",
    reports_card2_title: "Tickets por estado",
    reports_card3_title: "Total de usuarios por rol",
    reports_th_category: "Categoría",
    reports_th_status: "Estado",
    reports_th_role: "Rol",
    reports_th_total: "Total",

    // Usuarios
    users_title: "Gestión de usuarios",
    users_add_btn: "Nuevo usuario",
    users_th_id: "ID",
    users_th_name: "Nombre",
    users_th_lastname: "Apellido",
    users_th_email: "Email",
    users_th_role: "Rol",
    users_th_status: "Estado",
    users_th_actions: "Acciones",

    // Login
    login_title: "Bienvenido",
    login_subtitle: "Iniciá sesión en el centro de soporte NewGen.",
    login_email: "Correo electrónico",
    login_password: "Contraseña",
    login_submit: "Iniciar sesión",
    login_back_home: "← Volver al sitio corporativo"
  },

  en: {
    lang_btn: "🌐 EN",
    
    // Top Bar & Common
    back_to_dashboard: "Back to dashboard",
    back_to_tickets: "Back to tickets",
    back_to_inventory: "Back to inventory",
    back_to_users: "Back to users",
    logout_title: "Sign out",
    theme_title: "Toggle theme",
    lang_title: "Switch language",
    
    // Roles
    role_admin: "Admin",
    role_technician: "Technician",
    role_requester: "Requester",
    role_user: "User",

    // Dashboard - Welcome & Profile
    welcome_prefix: "Welcome, ",
    welcome_desc: "Manage your IT infrastructure and software assets in one place.",
    
    // Dashboard - Navigation Cards
    nav_home: "Dashboard",
    nav_inventory: "Inventory",
    nav_tickets: "Tickets",
    nav_helpdesk: "Help desk",
    nav_reports: "Reports",
    nav_users: "Users",

    // Dashboard - Metrics
    stat_stock: "Products in stock",
    stat_stock_low: "Low stock alert",
    stat_movements: "Monthly activity",
    stat_vs_month: "vs. previous month",

    // Dashboard - Chart
    chart_title: "Inventory trends",
    chart_in: "Stock in",
    chart_out: "Stock out",
    month_jan: "Jan",
    month_feb: "Feb",
    month_mar: "Mar",
    month_apr: "Apr",
    month_may: "May",
    month_jun: "Jun",
    month_jul: "Jul",
    month_aug: "Aug",
    month_sep: "Sep",
    month_oct: "Oct",
    month_nov: "Nov",
    month_dec: "Dec",

    // Dashboard - Recent Movements
    movements_title: "Recent movements",
    movements_view_all: "View all",
    movements_in: "In",
    movements_out: "Out",
    movements_item_laptops: "Lenovo ThinkPad T14 Laptops",
    movements_item_monitors: "Dell 24\" Monitors",
    movements_item_keyboards: "Logitech Mechanical Keyboards",
    movements_item_mice: "HP Wireless Mice",
    movements_sub_stock: "IT stock replenishment",
    movements_sub_assign: "Assigned to engineering",
    movements_sub_damaged: "Decommissioned (damaged)",
    movements_sub_welcome: "Onboarding welcome kit",

    // Inventory
    inv_title: "Hardware inventory",
    inv_add_btn: "Add new device",
    inv_th_id: "ID",
    inv_th_name: "Device name",
    inv_th_category: "Category",
    inv_th_brand: "Brand",
    inv_th_model: "Model",
    inv_th_status: "Status",
    inv_th_user: "Assigned user",
    inv_th_actions: "Actions",
    inv_action_edit: "Edit",
    inv_action_delete: "Delete",
    inv_unassigned: "Unassigned",

    // Tickets
    tickets_title: "Ticket management",
    tickets_add_btn: "Create new ticket",
    tickets_th_id: "ID",
    tickets_th_title: "Title",
    tickets_th_desc: "Description",
    tickets_th_date: "Date",
    tickets_th_status: "Status",
    tickets_th_priority: "Priority",
    tickets_th_user: "Requester",
    tickets_th_tech: "Assigned technician",
    tickets_unassigned_tech: "Unassigned",

    // Help Desk / Ticket nuevo
    new_ticket_title: "Create new ticket",
    new_ticket_problem: "Issue title:",
    new_ticket_problem_ph: "e.g. System failed to boot or no network",
    new_ticket_desc: "Detailed description:",
    new_ticket_desc_ph: "Describe the issue and the affected machine...",
    new_ticket_priority: "Priority:",
    prio_low: "Low",
    prio_medium: "Medium",
    prio_high: "High",
    new_ticket_user: "Requesting user:",
    new_ticket_tech: "Assigned technician:",
    new_ticket_submit: "Submit ticket",

    // Reports
    reports_title: "System reports",
    reports_print_btn: "Print report",
    reports_card1_title: "Equipment total by category",
    reports_card2_title: "Tickets by status",
    reports_card3_title: "Users total by role",
    reports_th_category: "Category",
    reports_th_status: "Status",
    reports_th_role: "Role",
    reports_th_total: "Total",

    // Users
    users_title: "User management",
    users_add_btn: "New user",
    users_th_id: "ID",
    users_th_name: "First name",
    users_th_lastname: "Last name",
    users_th_email: "Email",
    users_th_role: "Role",
    users_th_status: "Status",
    users_th_actions: "Actions",

    // Login
    login_title: "Welcome",
    login_subtitle: "Sign in to NewGen Operations & IT Center.",
    login_email: "Email address",
    login_password: "Password",
    login_submit: "Sign in",
    login_back_home: "← Back to corporate website"
  }
};

(function initAppI18n() {
  function getAppLang() {
    return localStorage.getItem('newgen_lang') || 'es';
  }

  function applyAppTranslations(lang) {
    const dict = newgenAppTranslations[lang] || newgenAppTranslations['es'];
    
    // Actualizar elementos con data-i18n
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      if (dict[key]) {
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
          if (el.hasAttribute('placeholder')) {
            el.setAttribute('placeholder', dict[key]);
          }
        } else {
          el.textContent = dict[key];
        }
      }
    });

    // Actualizar elementos con data-i18n-title
    document.querySelectorAll('[data-i18n-title]').forEach(el => {
      const key = el.getAttribute('data-i18n-title');
      if (dict[key]) {
        el.setAttribute('title', dict[key]);
      }
    });

    // Actualizar elementos con data-i18n-placeholder
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
      const key = el.getAttribute('data-i18n-placeholder');
      if (dict[key]) {
        el.setAttribute('placeholder', dict[key]);
      }
    });

    // Actualizar botón de alternancia
    const toggleBtn = document.getElementById('langToggle');
    if (toggleBtn) {
      toggleBtn.textContent = dict.lang_btn;
      toggleBtn.title = dict.lang_title;
    }

    // Actualizar lang en <html>
    document.documentElement.lang = lang;
  }

  function switchAppLanguage() {
    const current = getAppLang();
    const next = current === 'es' ? 'en' : 'es';
    localStorage.setItem('newgen_lang', next);
    applyAppTranslations(next);
  }

  // Ejecución inmediata
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      const activeLang = getAppLang();
      applyAppTranslations(activeLang);

      const toggleBtn = document.getElementById('langToggle');
      if (toggleBtn) {
        toggleBtn.addEventListener('click', switchAppLanguage);
      }
    });
  } else {
    const activeLang = getAppLang();
    applyAppTranslations(activeLang);

    const toggleBtn = document.getElementById('langToggle');
    if (toggleBtn) {
      toggleBtn.addEventListener('click', switchAppLanguage);
    }
  }
})();
