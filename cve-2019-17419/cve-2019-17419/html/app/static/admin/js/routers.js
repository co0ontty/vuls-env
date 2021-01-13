/*
后台路由
 */
window.ROUTERS = {
    home: {
        module: 'index',
        path: 'home',
        data: {
            c: 'index',
            a: 'dohome'
        },
        js: 'home'
    },
    manage: {
        js: 'manage',
        css: 'manage',
        sub: {
            add: {
                js: 'manage'
            }
        }
    },
    online: {
        css: 'online',
        sub: {
            set: {
                js: 'setonline'
            },
            list: {
                js: 'online'
            }
        }
    },
    seo: {
        sub: {
            seo: {
                js: 'seo'
            },
            link: {
                js: 'link'
            },
            anchor: {
                js: 'anchor'
            },
            pseudostatic: {
                js: 'pseudostatic'
            },
            staticpage: {
                js: 'staticpage',
                css: 'html'
            },
            sitemap: {
                js: 'sitemap'
            },
            tags: {
                js: 'tags'
            }
        }
    },
    link: {
        js: 'link'
    },
    myapp: {
        css: 'myapp',
        js: 'myapp',
        sub: {
            login: {
                js: 'login'
            },
            free: {
                js: 'free',
                css: 'myapp'
            },
            business: {
                js: 'business',
                css: 'myapp'
            },
            charge: {
                js: 'charge',
                css: 'myapp'
            }
        }
    },
    user: {
        sub: {
            list: {
                js: 'list'
            },
            group: {
                js: 'group'
            },
            attr: {
                js: 'attr',
                css: 'attr'
            },
            func: {
                js: 'func'
            },
            login: {
                js: 'login'
            },
            email: {
                js: 'email'
            }
        }
    },
    admin: {
        sub: {
            user: {
                js: 'admin'
            }
        }
    },
    safe: {
        sub: {
            logs: {
                js: 'logs'
            },
            safe: {
                js: 'safe'
            }
        }
    },
    databack: {
        sub: {
            backup: {
                js: 'backup'
            },
            recovery: {
                js: 'recovery'
            }
        },
        path: 'backup',
        js: 'backup'
    },
    webset: {
        js: 'webset',
        data: {
            nocommon: 1
        },
        sub: {
            email: {
                js: 'email'
            },
            thirdparty: {
                js: 'third'
            }
        }
    },
    column: {
        js: 'column',
        css: 'column'
    },
    language: {
        sub: {
            site: {
                js: 'site',
                css: 'lang'
            },
            admin: {
                js: 'admin',
                css: 'lang'
            },
            setting: {
                js: 'setting'
            }
        }
    },
    imgmanage: {
        sub: {
            thumbs: {
                js: 'thumbs',
                css: 'thumbs'
            },
            watermark: {
                js: 'watermark'
            }
        }
    },
    update: {
        js: 'update'
    },
    parameter: {
        sub: {
            list: {
                js: 'parameter'
            }
        }
    },
    message: {
        sub: {
            list: {
                js: 'message'
            }
        }
    },
    feedback: {
        sub: {
            list: {
                js: 'feedback'
            },
            set: {
                js: '#pub/js/form_sys_set'
            }
        }
    },
    job: {
        sub: {
            position_list: {
                js: 'job'
            },
            list: {
                js: 'job'
            },
            set: {
                js: '#pub/js/form_sys_set'
            }
        }
    },
    system: {
        sub: {
            news: {
                js: 'sys_news'
            },
            authcode: {
                data: {
                    c: 'authcode',
                    a: 'doindex'
                }
            }
        }
    },
    banner: {
        path: 'list',
        js: 'banner',
        data: {
            c: 'banner_admin',
            a: 'domanage'
        }
    },
    recycle: {
        js: 'recycle'
    },
    partner: {
        js: 'partner',
        css: 'partner'
    },
    menu: {
        js: 'menu'
    },
    search: {
        sub: {
            global: {
                js: 'search'
            },
            advanced: {
                js: 'advanced'
            }
        }
    }
};