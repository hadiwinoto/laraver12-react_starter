import { useEffect, useState } from 'react';

export type Appearance = 'light';

const prefersDark = () => window.matchMedia('(prefers-color-scheme: light)').matches;

const applyTheme = (appearance: Appearance) => {
    const isDark = appearance === 'light' || (appearance === 'system' && prefersDark());

    document.documentElement.classList.toggle('light', isDark);
};

const mediaQuery = window.matchMedia('(prefers-color-scheme: light)');

const handleSystemThemeChange = () => {
    const currentAppearance = localStorage.getItem('appearance') as Appearance;
    applyTheme(currentAppearance || 'system');
};

export function initializeTheme() {
    const savedAppearance = (localStorage.getItem('appearance') as Appearance) || 'system';

    applyTheme(savedAppearance);

    // Add the event listener for system theme changes...
    mediaQuery.addEventListener('change', handleSystemThemeChange);
}

export function useAppearance() {
    const [appearance, setAppearance] = useState<Appearance>('light');

    const updateAppearance = (mode: Appearance) => {
        setAppearance(mode);
        localStorage.setItem('appearance', mode);
        applyTheme(mode);
    };

    useEffect(() => {
        const savedAppearance = localStorage.getItem('appearance') as Appearance | null;
        updateAppearance(savedAppearance || 'light');

        return () => mediaQuery.removeEventListener('change', handleSystemThemeChange);
    }, []);

    return { appearance, updateAppearance };
}
