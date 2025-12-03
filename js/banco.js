// Conexão com o Supabase
const supabaseUrl = 'https://kdsuvlaeepwjzqnfvxxr.supabase.co';
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtkc3V2bGFlZXB3anpxbmZ2eHhyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxNTMwMTIsImV4cCI6MjA3MTcyOTAxMn0.iuOiaoqm3BhPyEMs6mtn2KlA2CIuYdnkcfmc36_Z8t8';
const db = supabase.createClient(supabaseUrl, supabaseKey);

// Função para buscar dados
async function carregarUsuarios() {
  const { data, error } = await db
    .from('admins')
    .select('*');

  if (error) {
    console.error('Erro ao carregar usuários:', error);
  } else {
    console.log('Usuários:', data);
    const lista = document.getElementById('listaUsuarios');
    if (lista) {
      lista.innerHTML = data.map(u => `<li>${u.nome}</li>`).join('');
    }
  }
}

carregarUsuarios();