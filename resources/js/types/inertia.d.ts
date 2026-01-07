import { PageProps as InertiaPageProps } from '@inertiajs/core'

export interface User {
  id: number
  name: string
  email: string
  role: string
}

export interface AuthProps {
  user: User | null
  hasActiveSubscription: boolean
}

export interface FlashProps {
  message: string | null
  error: string | null
  success: string | null
}

export interface SettingsProps {
  site_title: string | null
  site_logo: string | null
  site_favicon: string | null
  phone: string | null
  address: string | null
  footer_text: string | null
}

export interface PageProps extends InertiaPageProps {
  auth: AuthProps
  flash: FlashProps
  settings: SettingsProps
}

declare module '@inertiajs/vue3' {
  export function usePage<T = PageProps>(): {
    props: T
    url: string
    component: string
    version: string
  }
}
