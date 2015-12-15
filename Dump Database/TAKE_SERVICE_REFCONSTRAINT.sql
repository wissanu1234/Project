--------------------------------------------------------
--  Ref Constraints for Table TAKE_SERVICE
--------------------------------------------------------

  ALTER TABLE "SYSTEM"."TAKE_SERVICE" ADD CONSTRAINT "TAKE_SERVICE_FK2" FOREIGN KEY ("TRAVELLER_PASSPORT")
	  REFERENCES "SYSTEM"."TRAVELLER" ("PASSPORT_NO") ON DELETE CASCADE ENABLE;
