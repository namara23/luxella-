
CREATE POLICY "Public read luxella media" ON storage.objects FOR SELECT TO anon, authenticated USING (bucket_id = 'luxella-media');
CREATE POLICY "Admin upload luxella media" ON storage.objects FOR INSERT TO authenticated WITH CHECK (bucket_id = 'luxella-media' AND public.has_role(auth.uid(), 'admin'));
CREATE POLICY "Admin update luxella media" ON storage.objects FOR UPDATE TO authenticated USING (bucket_id = 'luxella-media' AND public.has_role(auth.uid(), 'admin'));
CREATE POLICY "Admin delete luxella media" ON storage.objects FOR DELETE TO authenticated USING (bucket_id = 'luxella-media' AND public.has_role(auth.uid(), 'admin'));
