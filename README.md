# Luxella Spaces

React + Vite + Tailwind site with Supabase backend.

## Deploy to Vercel
1. Push this folder to GitHub.
2. Import the repo on vercel.com/new (Vite auto-detected; vercel.json included).
3. Add environment variables (Production / Preview / Development):
   - VITE_SUPABASE_URL = https://hfdbcysencjfxtfdmxmf.supabase.co
   - VITE_SUPABASE_PUBLISHABLE_KEY = sb_publishable_9GsjoBr2kR2QHy3j2ugsvA_gcnDHZMG
   - VITE_SUPABASE_PROJECT_ID = hfdbcysencjfxtfdmxmf
4. Deploy.

## Local development
```
npm install
npm run dev
```

## Admin access
Visit `/auth`, sign up, then grant admin in Supabase SQL:
`INSERT INTO public.user_roles (user_id, role) VALUES ('<your-auth-user-uuid>', 'admin');`
