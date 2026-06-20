<x-guest-layout>
  <div>
    <h2 style="display:flex;align-items:center;gap:8px;margin-bottom:16px;font-size:20px;"><i class="fas fa-shield-alt" style="color:var(--accent);"></i> Admin Login</h2>

    @if ($errors->any())
      <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div style="margin-bottom:12px;">
        <label style="display:block;margin-bottom:4px;font-size:13px;font-weight:600;">Email</label>
        <input type="email" name="email" placeholder="Email" required style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
      </div>
      <div style="margin-bottom:16px;">
        <label style="display:block;margin-bottom:4px;font-size:13px;font-weight:600;">Password</label>
        <input type="password" name="password" placeholder="Password" required style="width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;box-sizing:border-box;">
      </div>
      <button type="submit" style="padding:10px 18px;background:#0f172a;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:14px;font-weight:500;"><i class="fas fa-sign-in-alt"></i> Login</button>
    </form>
  </div>
</x-guest-layout>