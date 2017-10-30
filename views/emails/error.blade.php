<h1>Error!</h1>

<h2>General Information</h2>

<h4>Timestamp:</h4>
<pre>{{print_r(@$content['timestamp'], 1)}}</pre>

<h4>Message:</h4>
<pre>{{print_r(@$content['msg'], 1)}}</pre>

<h4>File:</h4>
<pre>{{print_r(@$content['file'], 1)}}</pre>

<h4>Line:</h4>
<pre>{{print_r(@$content['line'], 1)}}</pre>

<h2>Stack Trace</h2>
<pre>{{print_r(@$content['trace'], 1)}}</pre>

<h2>Environment Variables</h2>

<h4>POST</h4>
<pre>{{print_r(@$content['post'], 1)}}</pre>

<h4>GET</h4>
<pre>{{print_r(@$content['get'], 1)}}</pre>

<h4>FILES</h4>
<pre>{{print_r(@$content['files'], 1)}}</pre>

<h4>SESSION</h4>
<pre>{{print_r(@$content['session'], 1)}}</pre>

<h4>COOKIES</h4>
<pre>{{print_r(@$content['cookie'], 1)}}</pre>

<h4>SERVER</h4>
<pre>{{print_r(@$content['server'], 1)}}</pre>
