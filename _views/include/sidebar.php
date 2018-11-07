	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.php">
				<img src="{ :app_url }vendors/images/logo.png" alt="">
			</a>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li>
						<a href="{ :app_url }" class="dropdown-toggle no-arrow">
							<span class="fa fa-home"></span><span class="mtext">Home</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="fa fa-pencil"></span><span class="mtext">Kunden</span>
						</a>
						<ul class="submenu">
							<li><a href="{ :app_url }kunden">Übersicht</a></li>
							<li><a href="{ :app_url }kunden/new">Neuer Kunde</a></li>
						</ul>
					</li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="fa fa-paper-plane"></span><span class="mtext">Rechnungen</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{ :app_url }rechnungen">Übersicht</a></li>
                            <li><a href="{ :app_url }rechnungen/new">Neue Rechnung</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{ :app_url }todo" class="dropdown-toggle no-arrow">
                            <span class="fa fa-list"></span><span class="mtext">TODO</span>
                        </a>
                    </li>
                    <li>
                        <a href="{ :app_url }monitor" class="dropdown-toggle no-arrow">
                            <span class="fa fa-ambulance"></span><span class="mtext">Monitoring</span>
                        </a>
                    </li>
				</ul>
			</div>
		</div>
	</div>