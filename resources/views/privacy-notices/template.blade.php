@php
    $clientName = $client->nombre_completo ?? '';
    $noticeDate = $date ?? now()->format('d/m/Y');
@endphp

<style>
    .privacy-document {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10.5px;
        line-height: 1.35;
        color: #111;
        background: #fff;
    }

    @page {
        margin: 25px 35px 30px 35px;
    }

    .privacy-page {
        position: relative;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .privacy-page-break {
        page-break-after: always;
    }

    .privacy-page:last-child {
        page-break-after: auto;
    }

    .privacy-header {
        width: 100%;
        margin-bottom: 22px;
    }

    .privacy-header-table {
        width: 100%;
        border-collapse: collapse;
    }

    .privacy-header-table td {
        vertical-align: middle;
        border: none;
    }

    .privacy-header-left {
        width: 55%;
        text-align: left;
    }

    .privacy-header-right {
        width: 45%;
        text-align: right;
    }

    .privacy-header img {
        max-height: 42px;
    }

    .privacy-title {
        text-align: center;
        font-weight: bold;
        font-size: 13px;
        line-height: 1.3;
        margin: 15px 0 22px;
        text-transform: uppercase;
    }

    .privacy-section-title {
        font-weight: bold;
        font-size: 11px;
        margin-top: 16px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .privacy-subtitle {
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .privacy-document p {
        margin: 0 0 8px;
        text-align: justify;
    }

    .privacy-document ul {
        margin: 4px 0 10px 22px;
        padding: 0;
    }

    .privacy-document li {
        margin-bottom: 3px;
        text-align: justify;
    }

    .privacy-page-number {
        text-align: right;
        font-size: 10px;
        margin-top: 18px;
    }

    .signatures-wrapper {
        margin-top: 35px;
        width: 100%;
    }

    .signatures-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .signatures-table td {
        border: none;
    }

    .signature-column {
        width: 50%;
        padding: 0 18px;
        text-align: center;
        vertical-align: bottom;
    }

    .signature-area {
        height: 75px;
        text-align: center;
        vertical-align: bottom;
    }

    .signature-empty-space {
        height: 75px;
    }

    .signature-image {
        max-width: 220px;
        max-height: 70px;
    }

    .signature-border {
        border-bottom: 1px solid #000;
        width: 100%;
    }

    .signature-label {
        font-weight: bold;
        font-size: 8.5px;
        margin-top: 5px;
    }

    .signature-name {
        font-size: 8.5px;
        margin-top: 4px;
    }

    .date-wrapper {
        width: 45%;
        margin: 28px auto 0;
        text-align: center;
    }

    .date-line {
        border-bottom: 1px solid #000;
        padding-bottom: 4px;
    }

    .date-label {
        font-weight: bold;
        font-size: 9px;
        margin-top: 5px;
    }
</style>


<div class="privacy-document">

    {{-- ========================================================= --}}
    {{-- PÁGINA 1 --}}
    {{-- ========================================================= --}}

    <div class="privacy-page privacy-page-break">

        @include('privacy-notices.partials.official-header')

        <div class="privacy-title">
            AVISO DE PRIVACIDAD INTEGRAL APLICABLE A LA CONTRATO DE COMPRAVENTA DE
            MOTOCICLETA NUEVA
        </div>

        <div class="privacy-section-title">
            I. IDENTIDAD Y DOMICILIO DEL RESPONSABLE:
        </div>

        <p>
            <strong>
                {{ $company['nombre'] ?? '—' }}
            </strong>,
            (en su subsecuente, <strong>“LA AGENCIA”</strong> y/o
            <strong>“LA EMPRESA”</strong> y/o
            <strong>“EL DISTRIBUIDOR”</strong>) cuyo domicilio fiscal es el ubicado
            en <strong>
                {{ strtoupper($company['direccion']['calle'] ?? '') }}

                @if (!empty($company['direccion']['numero']))
                    #{{ strtoupper($company['direccion']['numero']) }}
                @endif
                ,
                COLONIA
                {{ strtoupper($company['direccion']['colonia'] ?? '') }},
                MUNICIPIO DE
                {{ strtoupper($company['direccion']['municipio'] ?? '') }},
                ESTADO DE
                {{ strtoupper($company['direccion']['estado'] ?? '') }},
                C.P.
                {{ $company['direccion']['codigoPostal'] ?? '' }}.
            </strong>
        </p>

        <div class="privacy-section-title">
            II. DATOS PERSONALES QUE SERÁN SOMETIDOS A TRATAMIENTO
        </div>

        <div class="privacy-subtitle">
            1. Datos personales:
        </div>

        <p>
            Para llevar a cabo las finalidades descritas en el presente aviso de
            privacidad, le informamos que los datos personales que podrán ser
            sometidos a tratamiento son los siguientes:
        </p>

        <ul>
            <li>Datos de identificación.</li>
            <li>Datos patrimoniales.</li>
            <li>Datos de contacto.</li>
            <li>Datos laborales.</li>
        </ul>

        <div class="privacy-subtitle">
            2. Datos personales sensibles:
        </div>

        <p>
            Para las finalidades de tratamiento precisadas en este aviso de
            privacidad <strong>NO RECABAREMOS DATOS PERSONALES CONSIDERADOS
                SENSIBLES.</strong>
        </p>

        <div class="privacy-section-title">
            III. FINALIDADES DEL TRATAMIENTO
        </div>

        <div class="privacy-subtitle">
            A. Gestión contractual, administrativa y de cumplimiento normativo:
        </div>

        <ul>
            <li>
                Identificarle y validar su identidad para la compraventa de
                vehículos, refacciones, accesorios y servicios.
            </li>
            <li>
                Formalizar, administrar y dar cumplimiento a las relaciones
                jurídicas, comerciales o contractuales que establezca con la Agencia.
            </li>
            <li>
                Integrar expedientes de clientes para operaciones de compra, venta,
                consignación o financiamiento de vehículos.
            </li>
            <li>
                Gestionar trámites relacionados con el registro vehicular, placas,
                verificación, seguros y garantías.
            </li>
            <li>
                Atender solicitudes de información, cotizaciones, pruebas de manejo,
                aclaraciones y quejas.
            </li>
            <li>
                Dar cumplimiento a disposiciones legales y regulatorias aplicables
                en materia de identificación, control y prevención de operaciones.
            </li>
        </ul>

        <div class="privacy-subtitle">
            B. Servicios postventa y de calidad:
        </div>

        <ul>
            <li>
                Proporcionar y dar seguimiento a servicios de mantenimiento,
                reparación y refacciones.
            </li>
            <li>Cumplir con programas de garantía y servicios de taller.</li>
            <li>
                Elaborar reportes internos de control de calidad y satisfacción
                del cliente.
            </li>
            <li>
                Mantener actualizado un registro de historial de servicios y visitas.
            </li>
        </ul>

        <div class="privacy-subtitle">
            C. Mercadotecnia, publicidad y prospección comercial:
        </div>

        <ul>
            <li>
                Contactarle para informarle sobre promociones, nuevos modelos,
                servicios, refacciones, accesorios, financiamientos, seguros,
                programas de lealtad y eventos de la Agencia.
            </li>
            <li>
                Realizar actividades de publicidad personalizada, remarketing y
                segmentación de mercado con base en sus preferencias y antecedentes
                de compra.
            </li>
        </ul>

        <div class="privacy-page-number">
            Página 1 de 4
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PÁGINA 2 --}}
    {{-- ========================================================= --}}

    <div class="privacy-page privacy-page-break">

        @include('privacy-notices.partials.official-header')

        <ul>
            <li>
                Invitarle a participar en encuestas de satisfacción, estudios de
                mercado y campañas de mejora de servicios.
            </li>
        </ul>

        <div class="privacy-subtitle">
            D. Desarrollo de negocio y alianzas comerciales.
        </div>

        <ul>
            <li>
                Establecer alianzas con aseguradoras, financieras, bancos y
                proveedores para ofrecerle productos y servicios complementarios,
                en cuyo caso se recabará su consentimiento cuando sea necesario.
            </li>
            <li>
                Implementar programas de fidelidad y recompra de vehículos.
            </li>
        </ul>

        <div class="privacy-section-title">
            IV. TRANSFERENCIAS DE DATOS PERSONALES.
        </div>

        <p>
            “LA AGENCIA” no transferirá, comunicará, proporcionará ni pondrá a
            disposición de terceros la Información Confidencial o los Datos
            Personales de “EL TITULAR”, bajo ninguna modalidad o figura jurídica,
            incluyendo, de manera enunciativa mas no limitativa, solicitudes,
            requerimientos, convenios, contratos, relaciones comerciales, procesos
            de financiamiento, operaciones bancarias, seguros, servicios de terceros
            o cualquier otra relación jurídica o comercial, salvo que “EL TITULAR”
            haya otorgado previamente su consentimiento expreso para dicha
            transferencia, en los términos previstos por la legislación aplicable.
        </p>

        <p>
            En consecuencia, la sola solicitud de un tercero, incluyendo
            instituciones financieras, bancos, aseguradoras, empresas, proveedores,
            aliados comerciales, asesores, empresas filiales, subsidiarias,
            sociedades pertenecientes al mismo grupo corporativo o cualquier otra
            persona física o moral, no constituirá por sí misma una causa que
            faculte a “LA AGENCIA” para transferir, proporcionar o revelar
            Información Confidencial o Datos Personales de “EL TITULAR”. En estos
            casos, será indispensable contar con el consentimiento expreso de
            “EL TITULAR”, cuando éste sea legalmente exigible.
        </p>

        <p>
            Lo anterior será aplicable incluso cuando el tercero solicitante
            manifieste que la información es necesaria para la prestación de un
            servicio, el otorgamiento de un crédito o financiamiento, la contratación
            de un seguro, la realización de una operación comercial, la integración
            de un expediente, la celebración o ejecución de un contrato o cualquier
            otro propósito relacionado con “EL TITULAR”, salvo que exista una
            disposición legal que expresamente autorice o imponga dicha transferencia
            sin necesidad de consentimiento.
        </p>

        <p>
            Como única excepción a lo anterior, “LA AGENCIA” podrá transferir,
            comunicar o proporcionar Información Confidencial y/o Datos Personales a
            autoridades administrativas o judiciales competentes, cuando exista un
            requerimiento formal, mandato, orden, resolución o disposición legal que
            así lo establezca, o cuando la transferencia resulte necesaria para el
            cumplimiento de una obligación legal a cargo de “LA AGENCIA”. Lo anterior
            comprende, de manera enunciativa mas no limitativa, la información que
            deba ser proporcionada al Registro Público Vehicular (REPUVE), en
            cumplimiento de las disposiciones legales y administrativas aplicables.
        </p>

        <p>
            En todos los casos, “LA AGENCIA” limitará la información proporcionada
            a aquella que resulte estrictamente necesaria y pertinente para atender
            el requerimiento de la autoridad o cumplir con la obligación legal
            correspondiente, y adoptará las medidas de seguridad administrativas,
            técnicas y físicas necesarias para preservar la confidencialidad,
            integridad y seguridad de la información.
        </p>

        <p>
            Las transferencias que se realicen en los supuestos señalados en el
            presente apartado se efectuarán de conformidad con la Ley Federal de
            Protección de Datos Personales en Posesión de los Particulares y demás
            disposiciones aplicables.
        </p>

        <div class="privacy-section-title">
            V. MEDIDAS DE SEGURIDAD
        </div>

        <div class="privacy-page-number">
            Página 2 de 4
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PÁGINA 3 --}}
    {{-- ========================================================= --}}

    <div class="privacy-page privacy-page-break">

        @include('privacy-notices.partials.official-header')

        <p>
            “LA EMPRESA” implementará, mantendrá y, en su caso, actualizará las
            medidas de seguridad administrativas, técnicas y físicas que resulten
            apropiadas y razonables, de conformidad con la legislación aplicable y
            con estándares de seguridad reconocidos en la materia, a efecto de
            proteger la Información Confidencial y los Datos Personales contra daño,
            pérdida, alteración, destrucción, acceso, uso, tratamiento o divulgación
            no autorizados.
        </p>

        <p>
            Asimismo, “LA EMPRESA” adoptará las medidas necesarias para preservar en
            todo momento la confidencialidad, integridad y disponibilidad de la
            Información Confidencial y de los Datos Personales, procurando que el
            acceso a dicha información se limite exclusivamente a aquellas personas
            que, por razón de sus funciones, deban conocerla o tratarla.
        </p>

        <p>
            En caso de que “LA EMPRESA” permita el acceso, tratamiento o manejo de
            Información Confidencial o Datos Personales por parte de terceros,
            procurará que éstos se encuentren sujetos a obligaciones de
            confidencialidad y a medidas de seguridad administrativas, técnicas y
            físicas apropiadas, equivalentes a las previstas en la presente cláusula
            y a las exigidas por la legislación aplicable.
        </p>

        <div class="privacy-section-title">
            VI. EJERCICIO DE LO DERECHOS ARCO
        </div>

        <p>
            Conforme a lo dispuesto por la Ley, usted tiene derecho a solicitar al
            Distribuidor el Acceso, Rectificación, Cancelación, y/u Oposición
            (los “Derechos ARCO”) del Tratamiento y/o de sus Datos Personales,
            conforme a lo descrito a continuación:
        </p>

        <ul>
            <li>
                <strong>ACCESO:</strong> derecho a acceder a sus Datos Personales en
                posesión del Distribuidor y a obtener información relativa a las
                condiciones y alcance bajo los que sus Datos Personales sean Tratados;
            </li>

            <li>
                <strong>RECTIFICACIÓN:</strong> derecho a rectificar sus Datos
                Personales en caso de que sean incorrectos o incompletos;
            </li>

            <li>
                <strong>CANCELACIÓN:</strong> derecho a pedir que el Distribuidor deje
                de Tratar sus Datos Personales cuando considere que no estén siendo
                Tratados conforme a los principios y deberes establecidos en la Ley o
                su Reglamento;
            </li>

            <li>
                <strong>OPOSICIÓN:</strong> derecho a oponerse al Tratamiento de sus
                Datos Personales, para ciertas Finalidades del Tratamiento en
                específico, de entre las establecidas en el presente Aviso de
                Privacidad.
            </li>
        </ul>

        <p>
            Para ejercer sus Derechos ARCO, le pedimos contactar al responsable de
            la protección de datos del Distribuidor conforme a lo dispuesto en la
            sección titulada “Contacto”, del presente Aviso de Privacidad.
        </p>

        <p>
            Su solicitud deberá contener la siguiente información:
        </p>

        <ul>
            <li>
                Su nombre completo, domicilio, e información de contacto para
                contestar a la solicitud;
            </li>

            <li>Documento(s) que comprueben su identidad;</li>

            <li>
                Una descripción clara y precisa de los Datos Personales respecto de
                los que pretende ejercer sus Derechos ARCO;
            </li>

            <li>
                Cualquier otro elemento que facilite la localización de sus Datos
                Personales; y, según sea el caso,
            </li>

            <li>
                Las modificaciones que desee realizar / las limitaciones que desee
                aplicar al Tratamiento de sus Datos Personales.
            </li>
        </ul>

        <p>
            El Distribuidor le notificará respecto de la validez de su solicitud
            dentro de un plazo de 20 (veinte) días a partir de la fecha en que reciba
            la misma. Este periodo podrá extenderse una sola vez por un periodo de la
            misma duración, siempre que las circunstancias particulares del caso lo
            ameriten.
        </p>

        <div class="privacy-page-number">
            Página 3 de 4
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PÁGINA 4 --}}
    {{-- ========================================================= --}}

    <div class="privacy-page">

        @include('privacy-notices.partials.official-header')

        <p>
            Conforme a lo dispuesto por la Ley, el Distribuidor le enviará su
            respuesta a su solicitud adjuntando la evidencia relativa a lo que
            resuelva al respecto. Sus peticiones respecto del ejercicio de sus
            Derechos ARCO serán evaluadas conforme a lo dispuesto por la Ley y su
            validez será evaluada tomando en consideración las disposiciones de dicha
            Ley.
        </p>

        <p>
            Por favor considere que sus peticiones posiblemente no sean aprobadas en
            aquellos casos en que el Tratamiento de sus Datos Personales sea necesario
            para cumplir con lo dispuesto por la Ley o con los derechos u obligaciones
            del Distribuidor. Si su petición es válida, la resolución respectiva del
            Distribuidor será exigible dentro de un plazo de 15 (quince) días a partir
            de que le sea comunicado por el Distribuidor. Este periodo podrá
            extenderse una sola vez por un periodo de la misma duración, siempre que
            las circunstancias particulares del caso lo ameriten.
        </p>

        <div class="privacy-section-title">
            VII. MODIFICACIONES Y ACTUALIZACIONES AL PRESENTE AVISO DE PRIVACIDAD.
        </div>

        <p>
            El Distribuidor podrá en todo momento y a su entera discreción, modificar
            o actualizar el presente Aviso de Privacidad. En caso de realizar
            modificaciones sustanciales al mismo, la Empresa le notificará al
            respecto por medio de anuncios impresos, nuevas impresiones del presente
            Aviso de Privacidad, y/o por medios electrónicos tales como nuestra
            página en Internet y en su caso, le requerirá que otorgue su consentimiento
            nuevamente.
        </p>

        <div class="privacy-section-title">
            VIII. CONTACTO.
        </div>

        <p>
            Para realizar y enviar al Distribuidor alguna pregunta o comentario en
            torno al presente Aviso de Privacidad o al Tratamiento; para ejercer sus
            Derechos ARCO; para revocar el consentimiento que previamente haya
            otorgado respecto del Tratamiento; y para hacer uso de, o preguntar
            acerca de las opciones o medios por los que el Distribuidor pudiera
            limitar el uso y divulgación de los Datos Personales, le pedimos contactar
            al responsable de protección de datos del Distribuidor por cualquiera de
            los siguientes medios de manera física, en las oficinas corporativas o
            mediante correo electrónico del departamento legal.
        </p>

        <ul>
            <li>
                <strong>Dirección de correo electrónico:</strong>
                {{ $company['email'] ?? 'legal@rise.mx' }}
            </li>

            <li>
                <strong>Dirección de envíos:</strong>

                {{ $company['direccion']['calle'] ?? '' }}

                @if (!empty($company['direccion']['numero']))
                    #{{ $company['direccion']['numero'] }}
                @endif

                @if (!empty($company['direccion']['colonia']))
                    de la colonia {{ $company['direccion']['colonia'] }}
                @endif

                @if (!empty($company['direccion']['municipio']))
                    en {{ $company['direccion']['municipio'] }}
                @endif

                @if (!empty($company['direccion']['estado']))
                    , {{ $company['direccion']['estado'] }}
                @endif

                @if (!empty($company['direccion']['codigoPostal']))
                    con C.P. {{ $company['direccion']['codigoPostal'] }}
                @endif
                .
            </li>
        </ul>

        <div class="privacy-section-title">
            IX. Consentimiento para el Tratamiento de sus Datos Personales.
        </div>

        <p>
            Por medio de la presente, el titular de los Datos Personales reconoce que
            ha leído y entendido el presente Aviso de Privacidad y otorga su
            consentimiento para que sus Datos Personales sean objeto de Tratamiento y
            Transferencia, conforme a las Finalidades del Tratamiento previamente
            descritas (incluyendo las Finalidades Secundarias del Tratamiento) acorde
            con los términos descritos mediante el presente Aviso de Privacidad.
        </p>


        {{-- ========================================================= --}}
        {{-- FIRMAS DEL TITULAR --}}
        {{-- ========================================================= --}}

        <div class="signatures-wrapper">

            <table class="signatures-table">
                <tr>

                    @if(($notice->signature_type ?? null) === 'DIGITAL')

                        {{-- FIRMA DIGITAL --}}
                        <td class="signature-column">

                            <div class="signature-area">

                                @if (!empty($digitalSignature))

                                    <img src="{{ $digitalSignature }}" class="signature-image" alt="Firma digital del titular">

                                @else

                                    <div class="signature-empty-space"></div>

                                @endif

                            </div>

                            <div class="signature-border"></div>

                            <div class="signature-label">
                                FIRMA DIGITAL DEL TITULAR
                            </div>

                            @if ($clientName)

                                <div class="signature-name">
                                    {{ $clientName }}
                                </div>

                            @endif

                        </td>


                        {{-- FIRMA FÍSICA --}}
                        <td class="signature-column">

                            <div class="signature-area">
                                <div class="signature-empty-space"></div>
                            </div>

                            <div class="signature-border"></div>

                            <div class="signature-label">
                                FIRMA AUTÓGRAFA DEL TITULAR
                            </div>

                            @if ($clientName)

                                <div class="signature-name">
                                    {{ $clientName }}
                                </div>

                            @endif

                        </td>

                    @else

                        {{-- SOLO FIRMA FÍSICA --}}
                        <td class="signature-column" colspan="2">

                            <div class="signature-area">
                                <div class="signature-empty-space"></div>
                            </div>

                            <div class="signature-border"></div>

                            <div class="signature-label">
                                FIRMA AUTÓGRAFA DEL TITULAR
                            </div>

                            @if ($clientName)

                                <div class="signature-name">
                                    {{ $clientName }}
                                </div>

                            @endif

                        </td>

                    @endif

                </tr>
            </table>

        </div>


        {{-- FECHA --}}

        <div class="date-wrapper">

            <div class="date-line">
                {{ $noticeDate }}
            </div>

            <div class="date-label">
                FECHA
            </div>

        </div>


        <div class="privacy-page-number">
            Página 4 de 4
        </div>

    </div>

</div>