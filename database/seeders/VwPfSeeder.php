<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VwPfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('create or replace view vw_refbank
        as
        select
            rb.*
            , rr.rrs_desc
        from ref_bank rb
            left join ref_runstate rr
            on rb.rrs_id = rr.rrs_id;');

        DB::unprepared('CREATE OR REPLACE Procedure sp_insert_RefBank (
                p_bank_id REF_BANK.Bank_ID%TYPE,
                p_bank_name REF_BANK.bank_name%TYPE,
                p_bank_status REF_BANK.RRS_ID%TYPE
            )
            language sql
            as $$
                INSERT INTO Ref_Bank
                (Bank_ID, Bank_Name, RRS_ID) VALUES (p_bank_id, p_bank_name, p_bank_status);
            $$;');
        DB::unprepared('create or replace procedure sp_update_refBank (
            p_bankId REF_BANK.Bank_ID%TYPE,
            p_bankName REF_BANK.bank_name%TYPE,
            p_bank_status REF_BANK.RRS_ID%TYPE
        )
        language sql
        as $$
            UPDATE ref_bank Set bank_name  = p_bankName, rrs_id = p_bank_status where bank_id = p_bankId;
        $$;');
        DB::unprepared('create or replace procedure sp_delete_RefBank(p_BankID REF_BANK.Bank_ID%TYPE)
        language plpgsql
        as $$
            declare c1 cursor for SELECT ID FROM vw_BankSecret where code_bank = p_BankID;
            declare dbs varchar(50);
            declare	be_val integer := 0;
        BEGIN
            open c1;
            fetch c1 into dbs;
            close c1;

            begin
                select count(1) into be_val from vw_BankEndpoint where dbs_id = dbs;
            end;

            IF (be_val > 0)
            THEN
                BEGIN
                    DELETE FROM DAT_BANK_ENDPOINT WHERE DBS_ID = dbs;
                    DELETE FROM DAT_BANK_SECRET WHERE CODE_BANK  = p_BankID;
                    DELETE FROM Ref_Bank where Bank_ID = p_BankID;
                    COMMIT;
                END;
            ELSE
                BEGIN
                    DELETE FROM DAT_BANK_SECRET WHERE CODE_BANK  = p_BankID;
                    DELETE FROM Ref_Bank where Bank_ID = p_BankID;
                    COMMIT;
                END;
            END IF;
        end;
        $$;');
        DB::unprepared('create or replace view vw_BankSecret
        as
        select
            id
            , code_bank
            , client_id
            , client_secret
            , username
            , "password"
        from dat_bank_secret dbs
            order by code_bank;');
        DB::unprepared('CREATE OR REPLACE VIEW vw_AvailBankSecret
        AS
        SELECT
            BANK_ID
        FROM VW_REFBANK
        WHERE BANK_ID NOT IN
            (SELECT CODE_BANK FROM VW_BANKSECRET)
        ORDER BY BANK_ID ASC');
        DB::unprepared('create or replace procedure sp_Insert_bankSecret(
            p_id DAT_BANK_SECRET.ID%TYPE,
            p_bank_id DAT_BANK_SECRET.CODE_BANK%TYPE,
            p_cliet_id DAT_BANK_SECRET.CLIENT_ID%TYPE,
            p_client_secret DAT_BANK_SECRET.CLIENT_SECRET%TYPE,
            p_username DAT_BANK_SECRET.USERNAME%TYPE,
            p_password DAT_BANK_SECRET.PASSWORD%TYPE
        ) language sql
        as $$
            INSERT INTO DAT_BANK_SECRET
                (id, Code_Bank, CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD)
            VALUES
                (p_id, p_bank_id, p_cliet_id, p_client_secret, p_username, p_password);
        $$;');
        DB::unprepared('CREATE OR REPLACE PROCEDURE sp_update_bankSecret(
            p_id DAT_BANK_SECRET.ID%TYPE,
            p_bank_id DAT_BANK_SECRET.CODE_BANK%TYPE,
            p_cliet_id DAT_BANK_SECRET.CLIENT_ID%TYPE,
            p_client_secret DAT_BANK_SECRET.CLIENT_SECRET%TYPE,
            p_username DAT_BANK_SECRET.USERNAME%TYPE,
            p_password DAT_BANK_SECRET.PASSWORD%TYPE
        ) language sql
        as $$
            UPDATE DAT_BANK_SECRET SET
                Code_Bank = p_bank_id
                , CLIENT_ID = p_cliet_id
                , CLIENT_SECRET = p_client_secret
                , USERNAME = p_username
                , PASSWORD = p_password
            WHERE ID = p_id;
        $$;');
        DB::unprepared('CREATE OR REPLACE Procedure sp_del_bankSecret (
            p_id DAT_BANK_SECRET.ID%TYPE
        ) language sql
        as $$
            DELETE FROM DAT_BANK_SECRET where ID = p_id;
        $$;');
        DB::unprepared('CREATE OR REPLACE VIEW vw_BankEndpoint
        AS
        SELECT
            dbe.id
            , dbe.dbs_id
            , dbe.dbe_endpoint
            , vb.code_bank
            , rb.bank_name
            , dbe.ret_id
            , ret.name
            , dbe.rrs_id
            , rr.rrs_desc
        FROM
        DAT_BANK_ENDPOINT dbe
            LEFT JOIN REF_ENDPOINT_TYPE ret ON dbe.RET_ID = ret.ID
            LEFT JOIN VW_BANKSECRET vb ON dbe.DBS_ID = vb.ID
            LEFT JOIN REF_BANK rb ON vb.CODE_BANK = rb.BANK_ID
            left join ref_runstate rr on dbe.rrs_id = rr.rrs_i;');
        DB::unprepared('CREATE OR REPLACE VIEW vw_refEndpoint
        AS
        SELECT
            *
        FROM REF_ENDPOINT_TYPE ret;');
        DB::unprepared('CREATE OR REPLACE PROCEDURE sp_insert_bankEndpoint(
            p_bank_secret DAT_BANK_ENDPOINT.DBS_ID%TYPE
            , p_endpoint DAT_BANK_ENDPOINT.DBE_ENDPOINT%TYPE
            , p_endpoint_type DAT_BANK_ENDPOINT.RET_ID%type
            , p_status dat_bank_endpoint.rrs_id%type
        ) language sql
        as $$
            INSERT INTO DAT_BANK_ENDPOINT
                (dbs_id, dbe_endpoint, ret_id, rrs_id)
            VALUES
                (p_bank_secret, p_endpoint, p_endpoint_type, p_status);
        $$;');
        DB::unprepared('CREATE OR REPLACE PROCEDURE sp_update_bankEndpoint(
            p_bank_secret DAT_BANK_ENDPOINT.DBS_ID%TYPE
            , p_endpoint DAT_BANK_ENDPOINT.DBE_ENDPOINT%TYPE
            , p_endpoint_type DAT_BANK_ENDPOINT.RET_ID%type
            , p_status dat_bank_endpoint.rrs_id%type
        ) language sql
        as $$
            UPDATE DAT_BANK_ENDPOINT SET DBE_ENDPOINT = p_endpoint, rrs_id = p_status WHERE DBS_ID = p_bank_secret AND RET_ID = p_endpoint_type;
        $$;');
        DB::unprepared('CREATE OR REPLACE PROCEDURE sp_del_bankEndpoint (
            p_id DAT_BANK_ENDPOINT.DBS_ID%type
        ) language sql
        as $$
            DELETE FROM DAT_BANK_ENDPOINT WHERE DBS_ID = p_id;
        $$;');
        DB::unprepared('CREATE OR REPLACE VIEW vw_LogBankTransaction
        AS
        SELECT
            lbt.*
            , rst.RST_NAME
        FROM LOG_BANK_TRANSACTION lbt
            LEFT JOIN REF_SERVICE_TYPE rst ON lbt.RST_ID = rst.RST_ID
        ORDER BY lbt.LBT_CREATED DESC;');
        DB::unprepared('CREATE OR REPLACE VIEW vw_LogSIPDTransaction
        AS
        SELECT
            lst.*
            , rst.RST_NAME
            , ras.RAS_MESSAGE
            , ras.RAS_DESCRIPTION
        FROM LOG_SIPD_TRANSACTION lst
            LEFT JOIN REF_SERVICE_TYPE rst ON lst.RST_ID = rst.RST_ID
            LEFT JOIN REF_API_STATUS ras ON lst.RAS_ID = ras.RAS_ID
        ORDER BY lst.LST_CREATED DESC;');
        DB::unprepared("CREATE OR REPLACE VIEW vw_Overbooking_H
        AS
        SELECT
            to2.*
            ,to2.RAS_ID AS Status
            , vr.BANK_NAME AS SENDER_BANK_NAME
            , vr2.BANK_NAME AS RECIPIENT_BANK_NAME
            , CASE to2.RAS_ID
                WHEN '000' THEN 'Success'
                WHEN '900' THEN 'Success'
                WHEN '100' THEN 'Processed'
                ELSE 'Failed' END AS Status_Text
            , ras.RAS_MESSAGE AS Status_Message
        FROM TRX_OVERBOOKING to2
            LEFT JOIN VW_REFBANK vr ON to2.TBK_SENDER_BANK_ID = vr.BANK_ID
            LEFT JOIN VW_REFBANK vr2 ON to2.TBK_RECIPIENT_BANK_ID = vr2.BANK_ID
            LEFT JOIN REF_API_STATUS ras ON to2.RAS_ID = ras.RAS_ID
        ORDER BY to2.TBK_CREATED DESC;");
        DB::unprepared('CREATE OR REPLACE VIEW vw_MostActiveBank
        as
        SELECT
            voh.tbk_sender_bank_id
            , vr.BANK_NAME
            , COUNT(voh.tbk_sender_bank_id) AS countBank
        FROM VW_OVERBOOKING_H voh
            LEFT JOIN VW_REFBANK vr ON voh.tbk_sender_bank_id = vr.BANK_ID
        GROUP BY voh.tbk_sender_bank_id, vr.BANK_NAME
        ORDER BY countBank DESC;');
        DB::unprepared('CREATE OR REPLACE PROCEDURE sp_del_bankEndpoint (
            p_dbs_id DAT_BANK_ENDPOINT.dbs_id%type
            , p_id DAT_BANK_ENDPOINT.id%type
        ) language sql
        as $$
            DELETE FROM DAT_BANK_ENDPOINT where id = p_id AND DBS_ID = p_dbs_id;
        $$;');
        // DB::unprepared ('');
    }
}
